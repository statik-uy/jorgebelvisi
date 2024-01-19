<?php 
use Aws\Ses\SesClient;
use Aws\Exception\AwsException;
// If necessary, modify the path in he require statement below to refer to the 
// location of your Composer autoload.php file.
require 'vendor/autoload.php';

function sendMailAWS($mensaje, $para, $asunto){
  
    $SesClient = new SesClient([
        'profile' => 'default',
        'version' => '2010-12-01',
        'region'  => 'sa-east-1'
    ]);
    
    // Replace sender@example.com with your "From" address.
    // This address must be verified with Amazon SES.
    $sender_email = 'contacto@jorgebelvisi.com';
    
    // Replace these sample addresses with the addresses of your recipients. If
    // your account is still in the sandbox, these addresses must be verified.
    $recipient_emails = $para;
    
    // Specify a configuration set. If you do not want to use a configuration
    // set, comment the following variable, and the
    // 'ConfigurationSetName' => $configuration_set argument below.
    #$configuration_set = 'ConfigSet';
    
    $subject = $asunto;
    $plaintext_body = $mensaje;
    $html_body =  $mensaje;
    $char_set = 'UTF-8';
    
    try {
        $result = $SesClient->sendEmail([
            'Destination' => [
                'ToAddresses' => $recipient_emails,
            ],
            'ReplyToAddresses' => [$sender_email],
            'Source' => $sender_email,
            'Message' => [
              'Body' => [
                  'Html' => [
                      'Charset' => $char_set,
                      'Data' => $html_body,
                  ],
                  'Text' => [
                      'Charset' => $char_set,
                      'Data' => $plaintext_body,
                  ],
              ],
              'Subject' => [
                  'Charset' => $char_set,
                  'Data' => $subject,
              ],
            ],
            // If you aren't using a configuration set, comment or delete the
            // following line
            //'ConfigurationSetName' => $configuration_set,
        ]);
        $messageId = $result['MessageId'];
        echo "<script type='text/javascript'>alert('Tu message ha sido enviado exitosamente');</script>";
        echo "<script type='text/javascript'>window.location.href='https://jorgebelvisi.com';</script>";

    } catch (AwsException $e) {
        // output error message if fails
        echo $e->getMessage();
        echo "<script type='text/javascript'>alert('Hubo un error al enviar el mensaje, pruebe nuevamente.');</script>";
        #echo "<script type='text/javascript'>alert(".$e->getAwsErrorMessage().");</script>";
        echo "<script type='text/javascript'>window.location.href='https://jorgebelvisi.com';</script>";
        #echo("The email was not sent. Error message: ".$e->getAwsErrorMessage()."\n");
    }
}

$nombre = $_POST['name'];
$mail = $_POST['email'];
$asunto = $_POST['subject'];
$empresa = $_POST['message'];

$header = "from: jorgebel@jorgebelvisi.uy"."\r\n";
$header .= "X-Mailer:PHP/".phpversion()."\r\n";
$header .= "Mime-Version:1.0 \r\n";
$header .= "content-Type:text/plain";

$message = "Este message fue enviado por: ".$nombre."<br>";
$message .= "Su e-mail es: ".$mail."<br>";
$message .= "Asunto: ".$asunto."<br>";
$message .= "Mensaje: ".$empresa."<br>";
$message .= "Enviado el: ".date('d/m/Y',time());


$para = ['jorgebelvisi@hotmail.com'];
$asunto = 'Consulta';

sendMailAWS($message, $para, $asunto);
#sendMailAWS("Prueba", "lucaspintos909@gmail.com", "asd");

