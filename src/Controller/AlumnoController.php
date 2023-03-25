<?php

namespace App\Controller;

use App\Controller\Admin\AlumnoCrudController;
use App\Entity\Alumno;
use App\Entity\ArchivoCargaMasiva;
use App\Entity\Asignatura;
use App\Entity\Curso;
use App\Entity\CursoAsignatura;
use App\Entity\Periodo;
use App\Form\AlumnoType;
use App\Form\ArchivoCargaMasivaType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;

class AlumnoController extends AbstractController
{
    
    private $adminUrlGenerator;
    
    public function __construct(AdminUrlGenerator $adminUrlGenerator, EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->adminUrlGenerator = $adminUrlGenerator;
    }
    
    #[Route('/lista-alumnos', name: 'lista_alumnos')]
    public function alumnos(): Response
    {
        $periodo = $this->entityManager->getRepository(Periodo::class)->findOneBy(['nombre' =>'Primer Semestre']);
        $curso = $this->entityManager->getRepository(Curso::class)->findOneBy(['nombre' => 'Cuarto']);
        $asignatura = $this->entityManager->getRepository(Asignatura::class)->findOneBy(['nombre' => 'Educación Física y Salud']);
        $cursoAsignatura = $this->entityManager->getRepository(CursoAsignatura::class)->findOneBy(['curso' => $curso, 'asignatura' => $asignatura]);
            
        return $this->json($cursoAsignatura->toArray());
    }
    
    #[Route('/alumno/index', name: 'index')]
    public function dashboard(): Response
    {
        $periodo = $this->entityManager->getRepository(Periodo::class)->findOneBy(['nombre' =>'Primer Semestre']);
        $curso = $this->entityManager->getRepository(Curso::class)->findOneBy(['nombre' => 'Cuarto']);
        $asignatura = $this->entityManager->getRepository(Asignatura::class)->findOneBy(['nombre' => 'Educación Física y Salud']);
        $cursoAsignatura = $this->entityManager->getRepository(CursoAsignatura::class)->findOneBy(['curso' => $curso, 'asignatura' => $asignatura]);

        $cantidadNotas = 0;
        foreach ($cursoAsignatura->getNotas() as $key => $nota) {
            if($nota->getPeriodo() == $periodo){
                $cantidadNotas++;
            }
        }
        // return $this->render('base.html.twig');
                
        return $this->render('dashboard/index.html.twig',[
            'cursoAsignatura' => $cursoAsignatura,
            'periodo' => $periodo,
            'cantidadNotas' => $cantidadNotas
        ]);
    }
    
    #[Route('/alumnos/carga-masiva', name: 'carga_masiva_alumnos')]
    public function index(Request $request, SluggerInterface $slugger,  PersistenceManagerRegistry $doctrine): Response
    {
        $em = $doctrine->getManager();
        $archivoCargaMasiva = new ArchivoCargaMasiva();
        $form = $this->createForm(ArchivoCargaMasivaType::class, $archivoCargaMasiva);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $arhivoAlumnos = $form->get('path')->getData();
            $curso = $form->get('curso')->getData();

            if ($arhivoAlumnos) {
                $originalFilename = pathinfo($arhivoAlumnos->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$arhivoAlumnos->guessExtension();
                // Mover el archivo al directorio donde son almacenados
                try {
                    $arhivoAlumnos->move(
                        $this->getParameter('archivo_carga_masiva_directory'),
                        $newFilename
                    );

                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
               
                // getParameter() -> Parámetros son configurados en services.yaml
                $pathFile = $this->getParameter('archivo_carga_masiva_directory') . '/' . $newFilename;
                
                $alumnos = $this->getAlumnos($pathFile);

                $sumAbonos = 0;
                $sumEgresos = 0;

                foreach ($alumnos as $index => $nombreAlumno) {
                    $alumno = new Alumno();

                    $alumno->setNombre($nombreAlumno);
                    $alumno->setCurso($curso);
                    $em->persist($alumno);
                    // $abono[9] => Cheques y otros
                    // $abono[10] => Depósitos y abonos
                }
            }
            
        $em->flush();

        return $this->redirect($this->adminUrlGenerator->setController(AlumnoCrudController::class)->setAction('index'));
        }

        return $this->renderForm('alumno/carga-masiva.html.twig',[
            'form' => $form
        ]);
    }


    public function getAlumnos($xlsxFile){

        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = $reader->load($xlsxFile);
        $dataFromSpreadsheet = $this->createDataFromSpreadsheet($spreadsheet);
        return $this->extraerAlumnos($dataFromSpreadsheet);
    }

    protected function createDataFromSpreadsheet($spreadsheet)
    {
        $dataSpreadsheet = [];
        foreach ($spreadsheet->getWorksheetIterator() as $worksheet) {
            $worksheetTitle = $worksheet->getTitle();
            $dataSpreadsheet[$worksheetTitle] = [
                'columnNames' => [],
                'columnValues' => [],
            ];
            foreach ($worksheet->getRowIterator() as $row) {
                $rowIndex = $row->getRowIndex();
                if ($rowIndex > 2) {
                    $dataSpreadsheet[$worksheetTitle]['columnValues'][$rowIndex] = [];
                }
                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(false); // Loop over all cells, even if it is not set
                foreach ($cellIterator as $cell) {
                    if ($rowIndex === 2) {
                        $dataSpreadsheet[$worksheetTitle]['columnNames'][] = $cell->getCalculatedValue();
                    }
                    if ($rowIndex > 2) {
                        $dataSpreadsheet[$worksheetTitle]['columnValues'][$rowIndex][] = $cell->getCalculatedValue();
                    }
                }
            }
        }
        return $dataSpreadsheet;
    }

    public function extraerAlumnos($dataSpreadsheet){
        $nombres = [];
        foreach ($dataSpreadsheet as $pageSpreadsheet) {

            // dump(array_slice($pageSpreadsheet['columnValues'],1,20));
            // dump($pageSpreadsheet['columnValues']);
            foreach (array_slice($pageSpreadsheet['columnValues'],1,50) as  $index=>$value) {
                if($value[1] != null && $value[1] != 'NOMBRES' ){
                    // dump($value[1]);
                    $alumnos[] = ucwords(strtolower($value[1]));
                    // $alumnos[] = ucwords(strtolower($nombres[3])) . ' ' . ucwords(strtolower($nombres[2])) . ' ' . ucwords(strtolower($nombres[1])) . ' ' . ucwords(strtolower($nombres[0])) ;
                }
            }
        }
        return $alumnos;
    }

}
