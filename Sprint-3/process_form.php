<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Receber os dados do formulário
    $name = $_POST['name'];
    $email = $_POST['email']; // Usando o email fornecido pelo remetente do formulário
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    // Cria uma nova instância do PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Configurações do servidor
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';            // Host SMTP
        $mail->SMTPAuth = true;                    // Habilitar autenticação SMTP
        $mail->Username = 'seu_email@gmail.com';   // Seu endereço de e-mail
        $mail->Password = 'sua_senha_de_app';      // Sua senha de app do e-mail
        $mail->SMTPSecure = 'tls';                 // Ativar criptografia TLS
        $mail->Port = 587;                         // Porta TCP para TLS

        // Destinatários
        $mail->setFrom($email, $name);             // Usando o email e nome fornecidos pelo remetente do formulário
        $mail->addAddress('nickmanraujo@gmail.com');

        // Conteúdo do e-mail
        $mail->isHTML(true);
        $mail->Subject = "New message from $name: $subject";
        $mail->Body    = "You have received a new message from the contact form on your website.<br><br>".
                         "<b>Name:</b> $name<br>".
                         "<b>Email:</b> $email<br>".
                         "<b>Subject:</b> $subject<br>".
                         "<b>Message:</b><br>$message";

        $mail->send();
        echo 'Mensagem enviada com sucesso!';
    } catch (Exception $e) {
        echo "Erro ao enviar mensagem. Mailer Error: {$mail->ErrorInfo}";
    }
} else {
    echo "Método de requisição inválido.";
}
?>
