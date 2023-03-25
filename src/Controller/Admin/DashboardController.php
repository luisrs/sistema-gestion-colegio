<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        // return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(UsuarioCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        return $this->render('App\Dashboard\index.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('F546');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Usuarios', 'fas fa-list', \App\Entity\Usuario::class);
        yield MenuItem::linkToCrud('Profesores', 'fas fa-list', \App\Entity\Profesor::class);
        yield MenuItem::linkToCrud('Alumnos', 'fas fa-list', \App\Entity\Alumno::class);
        yield MenuItem::linkToCrud('Asignaturas', 'fas fa-list', \App\Entity\Asignatura::class);
        yield MenuItem::linkToCrud('Cursos', 'fas fa-list', \App\Entity\Curso::class);
        yield MenuItem::linkToCrud('Curso Asignatura', 'fas fa-list', \App\Entity\CursoAsignatura::class);
        yield MenuItem::linkToCrud('Notas', 'fas fa-list', \App\Entity\Nota::class);
        yield MenuItem::section('Año Escolar');
        yield MenuItem::linkToCrud('Periodos', 'fas fa-list', \App\Entity\Periodo::class);
        yield MenuItem::section('Alumnos');
        yield MenuItem::linkToCrud('Lista', 'fas fa-gears', \App\Entity\Alumno::class)->setController(\App\Controller\Admin\AlumnoCrudController::class);
        yield MenuItem::linkToRoute('Carga masiva', 'fa ...', 'carga_masiva_alumnos');
        yield MenuItem::linkToRoute('Ingresar notas', 'fa ...', 'index');



    }
}
