<?php
    
    namespace App\Globais;
 
    use PHPMailer\PHPMailer\PHPMailer;
    

    use App\Models\EmailParametro;

     class modMain {

        private static $instance;
        private $container;

        //cria os outros atributos       
        //private $servidorSmtp = "teste";
        
        public function __construct($container){
            $this->container = $container;
        }

      
        public function __get($valor){
            return $this->$valor;
        }
        public function __set($propriedade,$valor){
            $this->$propriedade = $valor;
        }
        
        public static function getInstance($container)
        {
            if(!isset(self::$instance)) 
            {     
                self::$instance = new modMain($container);
            }
            return self::$instance;
        }

        public function EnviarEmail($destinatario, $mensagem, $assunto, $salvarNoBanco){
            
            //salvar no banco de dados com o status NAO ENVIADO
            $id = 1;  //daí retorno o id da mensagem

            $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
            try {
                
                $configs = EmailParametro::where("ID", 1)->first()->get();
                
                $configs = $configs[0];
                
                $SMTP = $configs['SMTP'];
                $Email = $configs['EMAIL'];
                $Senha = $configs['SENHA'];
                $Porta = $configs['PORTA'];
                $TipoDeSeguranca = $configs['TIPOSEGURANCA'];
                $NomeExibicao = $configs['NOMEEXIBICAO'];
                $EmailExibicao = $configs['EMAILEXIBICAO'];
                $RequerAutenticacao =  $configs['REQUER_AUTENTICACAO'];
                $EnviarHtml = $configs['ENVIAHTML'];

                
                
                $mail->SMTPDebug = false;                             // Enable verbose debug output
                $mail->SMTPAuth = true; //$RequerAutenticacao;                               // Enable SMTP authentication
                $mail->isSMTP();                                      // Set mailer to use SMTP
                $mail->Mailer = "smtp";
                $mail->Host = $SMTP;  // Specify main and backup SMTP servers
                $mail->Username = $Email;                // SMTP username
                $mail->Password = $Senha;                       // SMTP password
                //$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
                $mail->Port = $Porta;                                    // TCP port to connect to
    
                //Recipients
                $mail->setFrom($Email, $NomeExibicao);
                $mail->addAddress($destinatario);               // Name is optional
    
    
                //Attachments
                //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
                //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
    
                //Content
                $mail->isHTML($EnviarHtml);                                  // Set email format to HTML
                $mail->Subject = $assunto;
                $mail->Body    = $mensagem;
                $mail->AltBody = $mensagem;
                
                $mail->send();
                
                //atualiza status no banco para ENVIADO
                

                
                return "ok";

            } catch (Exception $e) {
                echo 'Mensagem não pode ser enviado. Erro: ', $mail->ErrorInfo;
            }
        }

    }



?>