<?php

namespace App\Controller;

use App\Entity\Alumno;
use App\Entity\Asignatura;
use App\Entity\Curso;
use App\Entity\CursoAsignatura;
use App\Entity\Nota;
use App\Entity\NotaAlumno;
use App\Entity\Periodo;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\JsonResponse;


class NotasController extends AbstractController
{
    #[Route('/notas', name: 'app_notas')]
    public function index(): Response
    {
        return $this->render('notas/index.html.twig', [
            'controller_name' => 'NotasController',
        ]);
    }

    #[Route('/registro-notas', name: 'registro_notas')]
    public function registroNotas(Request $request, EntityManagerInterface $entityManager): Response
    {

        $periodo = $entityManager->getRepository(Periodo::class)->findOneBy(['nombre' => 'Primer Semestre']);

        $entityAsignatura = $entityManager->getRepository(Asignatura::class)->find($request->query->all()['asignatura']['id']);
        
        $entityCurso = $entityManager->getRepository(Curso::class)->find($request->query->all()['curso']['id']);
        
        
        $entityCursoAsignatura = $entityManager->getRepository(CursoAsignatura::class)->findOneBy(['curso' => $entityCurso, 'asignatura' => $entityAsignatura]);

        
        $alumnos = $request->query->all()['alumnos'];
        foreach ($alumnos as $key => $alumno) {
            if(isset($alumno['notas'])){
                $entityAlumno = $entityManager->getRepository(Alumno::class)->find($alumno['id']);
                foreach ($alumno['notas'] as $key => $nota) {
                    
                    $entityNota = $entityManager->getRepository(Nota::class)->find($nota['id']);
                    
                    $notaAlumno = new NotaAlumno();
                    $notaAlumno->setAlumno($entityAlumno);
                    $notaAlumno->setAsignatura($entityAsignatura);
                    $notaAlumno->setCalificacion($nota['calificacion']);
                    $notaAlumno->setPeriodo($periodo);
                    $notaAlumno->setNotaTemplate($entityNota);
                    $entityManager->persist($notaAlumno);
                }
            }
        }
        $entityManager->flush();
        return new JsonResponse([
            'status' => true,
            'msg' => 'Notas registradas'
        ]);
    }

    #[Route('/descargar-notas', name: 'decargar_notas')]
    public function descargarNotas(Request $request, EntityManagerInterface $entityManager): Response
    {        
        $alumnos = $request->query->all()['alumnos'];
        // dump($alumnos);
        // die();

        $html = $this->render('notas/formato_pdf.html.twig', [
            'alumnos' => $alumnos,
            // 'produccion' => $tarjetaProduccion,
            // 'tarjetasDetalle' => $tarjetasDetalle,
            'document_root' => $_SERVER['DOCUMENT_ROOT'],
            'dev'=>false
        ])->getContent();
        return new Response ($html);
    }
}
