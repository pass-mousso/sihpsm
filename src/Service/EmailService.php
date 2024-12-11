<?php

namespace App\Service;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Address;

class EmailService
{

    public function __construct(
        MailerInterface $mailer
    ){}

    /**
     * Envoie un email simple.
     *
     * @param string $to Adresse email du destinataire.
     * @param string $subject Sujet de l'email.
     * @param string $content Contenu du message (texte ou HTML).
     * @param string|null $from Adresse email de l'expéditeur (par défaut).
     * @return void
     */
    public function sendSimpleEmail(string $to, string $subject, string $content, string $from = null): void
    {
        $email = (new Email())
            ->from($from ?? 'default@example.com')
            ->to($to)
            ->subject($subject)
            ->text(strip_tags($content))
            ->html($content);

        $this->mailer->send($email);
    }

    /**
     * Envoie un email avec des pièces jointes.
     *
     * @param string $to Adresse email du destinataire.
     * @param string $subject Sujet de l'email.
     * @param string $content Contenu du message (texte ou HTML).
     * @param array $attachments Tableau des chemins vers les fichiers.
     * @param string|null $from Adresse email de l'expéditeur (par défaut).
     * @return void
     */
    public function sendEmailWithAttachments(string $to, string $subject, string $content, array $attachments, string $from = null): void
    {
        $email = (new Email())
            ->from($from ?? 'default@example.com')
            ->to($to)
            ->subject($subject)
            ->text(strip_tags($content))
            ->html($content);

        foreach ($attachments as $attachment) {
            $email->attachFromPath($attachment);
        }

        $this->mailer->send($email);
    }

    /**
     * Envoie un email avec un accusé de réception.
     *
     * @param string $to Adresse email du destinataire.
     * @param string $subject Sujet de l'email.
     * @param string $content Contenu du message (texte ou HTML).
     * @param string|null $from Adresse email de l'expéditeur (par défaut).
     * @return void
     */
    public function sendEmailWithReadReceipt(string $to, string $subject, string $content, string $from = null): void
    {
        $email = (new Email())
            ->from($from ?? 'default@example.com')
            ->to($to)
            ->subject($subject)
            ->text(strip_tags($content))
            ->html($content)
            ->headers->addTextHeader('Disposition-Notification-To', $from ?? 'default@example.com');

        $this->mailer->send($email);
    }

    /**
     * Envoie un email à plusieurs destinataires en copie et copie cachée.
     *
     * @param array $to Liste des destinataires principaux.
     * @param string $subject Sujet de l'email.
     * @param string $content Contenu du message (texte ou HTML).
     * @param array|null $cc Liste des destinataires en copie (facultatif).
     * @param array|null $bcc Liste des destinataires en copie cachée (facultatif).
     * @param string|null $from Adresse email de l'expéditeur (par défaut).
     * @return void
     */
    public function sendEmailToMultipleRecipients(array $to, string $subject, string $content, array $cc = null, array $bcc = null, string $from = null): void
    {
        $email = (new Email())
            ->from($from ?? 'default@example.com')
            ->to(...$to)
            ->subject($subject)
            ->text(strip_tags($content))
            ->html($content);

        if ($cc) {
            $email->cc(...$cc);
        }

        if ($bcc) {
            $email->bcc(...$bcc);
        }

        $this->mailer->send($email);
    }
}
