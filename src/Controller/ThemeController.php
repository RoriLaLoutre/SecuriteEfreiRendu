<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ThemeController extends AbstractController
{
    #[Route('/theme/{mode}', name: 'app_theme_switch')]
    public function switchTheme(string $mode, Request $request): Response
    {
        if (!in_array($mode, ['light', 'dark'])) {
            $mode = 'light';
        }

        $response = $this->redirect($request->headers->get('referer', '/')); 

        $cookie = Cookie::create('theme_mode')
            ->withValue($mode)
            ->withExpires((new \DateTime())->modify('+1 year'))
            ->withPath('/')
            ->withHttpOnly(false);

        $response->headers->setCookie($cookie);

        return $response;
    }
}