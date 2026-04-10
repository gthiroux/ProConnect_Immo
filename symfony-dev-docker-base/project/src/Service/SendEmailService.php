<?php
namespace App\Service;

use App\Entity\Request;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class SendEmailService
{
    public function __construct(
        private MailerInterface $mailer,
        private UrlGeneratorInterface $urlGenerator
    ) {}

    public function send(
        string $from,
        string $to,
        string $subject,
        string $template,
        array $context
    ): void {
        $email = (new TemplatedEmail())
            ->from($from)
            ->to($to)
            ->subject($subject)
            ->htmlTemplate("emails/$template.html.twig")
            ->context($context);

        $this->mailer->send($email);
    }

    public function sendWithRequest(
        string $from,
        string $subject,
        string $template,
        Request $request,
        string $route = 'localhost:8080/front/document.php?',
        array $extraContext = []
    ): void {
        // Génération de l'URL à partir de l'UUID
        $url = $this->urlGenerator->generate(
            $route,
            ['uuid' => $request->getUUID()],
            UrlGeneratorInterface::ABSOLUTE_URL
        );

        // Contexte envoyé au template Twig
        $context = array_merge([
            'request'   => $request,
            'url'       => $url,
            'code_mail' => $request->getCodeMail(),
            'firstname' => $request->getFirstname(),
            'lastname'  => $request->getLastname(),
        ], $extraContext);

        $email = (new TemplatedEmail())
            ->from($from)
            ->to($request->getEmail())
            ->subject($subject)
            ->htmlTemplate("emails/$template.html.twig")
            ->context($context);

        $this->mailer->send($email);
    }
}