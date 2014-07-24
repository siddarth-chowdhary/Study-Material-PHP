<?php
ini_set("display_errors","1");
include_once "templates/base.php";
session_start();
set_include_path("../src/" . PATH_SEPARATOR . get_include_path());
require_once 'Google/Client.php';
require_once 'Google/Service/Gmail.php';
/*
* set up the client and authentications required.
*/
$client_id = '416686001941-k60ah89i65g8vboc3s9i2tce7qiql59p.apps.googleusercontent.com';
$client_secret = 'fJ3D82N1qhHJRiPYQ6tnszjc';
$redirect_uri = 'http://localhost/google-api-php-client-master/examples/user-example.php';
$client = new Google_Client();
$client->setApplicationName("google-api-project");
$client->setClientId($client_id);
$client->setClientSecret($client_secret);
$client->setRedirectUri($redirect_uri);
$client->addScope("https://mail.google.com/","https://www.googleapis.com/auth/gmail.readonly","https://www.googleapis.com/auth/gmail.modify","https://www.googleapis.com/auth/gmail.compose");
$client->setDeveloperKey("416686001941-k60ah89i65g8vboc3s9i2tce7qiql59p@developer.gserviceaccount.com");
/* set the access token in sesion */
if(isset($_GET['code'])) {
  $client->authenticate($_GET['code']);
  $_SESSION['access_token'] = $client->getAccessToken();
}
/* if access token is set in session set the client otherwise get the credentials from user*/
if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
  $client->setAccessToken($_SESSION['access_token']);
} else {
  $authUrl = $client->createAuthUrl();
}
/* call to methods starts*/
// $service = new Google_Service_Gmail($client);
// $message = listMessages($service,"siddarth.chowdhary@osscube.com");

//  var_dump($message);

/*
* api function example
*/
 function listMessages($service, $userId) {
   $pageToken = NULL;
   $messages = array();
   $opt_param = array();
   do {
     try {
       if ($pageToken) {
         $opt_param['pageToken'] = $pageToken;
       }
       $messagesResponse = $service->users_messages->listUsersMessages($userId, $opt_param);
       if ($messagesResponse->getMessages()) {
         $messages = array_merge($messages, $messagesResponse->getMessages());
         $pageToken = $messagesResponse->getNextPageToken();
       }
     } catch (Exception $e) {
       print 'An error occurred: ' . $e->getMessage();
     }
   } while ($pageToken);


   foreach ($messages as $message) {
     $messageId = $message->getId();
     print 'Message with ID: ' . $message->getId() . '<br/>';
   }

   return $messages;
 }
//getMessage($service, 'mohit.gupta@osscube.com', '146d170ee5919bbe');
/**
 * Get Message with given ID.
 *
 * @param  Google_Service_Gmail $service Authorized Gmail API instance.
 * @param  string $userId User's email address. The special value 'me'
 * can be used to indicate the authenticated user.
 * @param  string $messageId ID of Message to get.
 * @return Google_Service_Gmail_Message Message retrieved.
 */
function getMessage($service, $userId, $messageId) {
  try {
    $message = $service->users_messages->get($userId, $messageId);
    echo "<pre>";
    print_r($message);
    print 'Message with ID: ' . $message->getId() . ' retrieved.';
    return $message;
  } catch (Exception $e) {
    print 'An error occurred: ' . $e->getMessage();
  }
}

// $email = 'mohit.gupta@osscube.com';
// $part = new Google_Service_Gmail_MessagePartBody();
// $part->setData('Testing');

// // $header = new Google_Service_Gmail_MessagePartHeader();
// // $header->setName("Content-Type");
// // $header->setValue("text/html");
// // $header->setName("Content-Transfer-Encoding");
// // $header->setValue("quoted-printable");
// // $header->setName("Content-Disposition");
// // $header->setValue("inline");

// $msg= new Google_Service_Gmail_MessagePart();
// $msg->setBody($part);

// $message = new Google_Service_Gmail_Message();
// $message->setPayload($msg);
// $message->setRaw(base64_encode($email));
// sendMessage($service,'me',$message);



/**
 * Send Message.
 *
 * @param  Google_Service_Gmail $service Authorized Gmail API instance.
 * @param  string $userId User's email address. The special value 'me'
 * can be used to indicate the authenticated user.
 * @param  Google_Service_Gmail_Message $message Message to send.
 * @return Google_Service_Gmail_Message sent Message.
 */
function sendMessage($service, $userId, $message) {
  try {
    $message = $service->users_messages->send($userId, $message);
    print 'Message with ID: ' . $message->getId() . ' sent.';
    return $message;
  } catch (Exception $e) {
    print 'An error occurred: ' . $e->getMessage();
  }
}


/**
 * Create a Message from an email formatted string.
 *
 * @param  string $email Email formatted string.
 * @return Google_Service_Gmail_Message Message containing email.
 */
// function createMessage($email) {
//   $message = new Google_Service_Gmail_Message();
//   $message->setRaw(base64_encode($email));
//   return $message;
// }




// createDraft($service,'me',createMessage('siddarth.chowdhary@osscube.com'));
/**
 * Create Draft email.
 *
 * @param  Google_Service_Gmail $service Authorized Gmail API instance.
 * @param  string $userId User's email address. The special value 'me'
 * can be used to indicate the authenticated user.
 * @param  Google_Service_Gmail_Message $message Message of the created Draft.
 * @return Google_Service_Gmail_Draft Created Draft.
 */
// function createDraft($service, $user, $message) {
//   $draft = new Google_Service_Gmail_Draft();
//   $draft->setMessage($message);
//   try {
//     $draft = $service->users_drafts->create($user, $draft);
//     print 'Draft ID: ' . $draft->getId();
//   } catch (Exception $e) {
//     print 'An error occurred: ' . $e->getMessage();
//   }
//   return $draft;
// }


/**
 * Create a Message from an email formatted string.
 *
 * @param  string $email Email formatted string.
 * @return Google_Service_Gmail_Message Message containing email.
 */
// function createMessage($email) {
//   $message = new Google_Service_Gmail_Message();
//   $message->setRaw(base64_encode($email));
//   return $message;
// }



$service = new Google_Service_Gmail($client);
$drafts = listDrafts($service,"siddarth.chowdhary@osscube.com");
echo '<pre>';
print_r($drafts);
/**
 * Retrieve a List of Drafts.
 *
 * @param  Google_Service_Gmail $service Authorized Gmail API instance.
 * @param  string $userId User's email address. The special value 'me'
 * can be used to indicate the authenticated user.
 * @return Array of Drafts.
 */
function listDrafts($service, $userId) {
  $drafts = array();

  try {
    $draftsResponse = $service->users_drafts->listUsersDrafts($userId);
    if ($draftsResponse->getDrafts()) {
      $drafts = array_merge($drafts, $draftsResponse->getDrafts());
    }
  } catch (Exception $e) {
    print 'An error occurred: ' . $e->getMessage();
  }

  foreach ($drafts as $draft) {
    print 'Draft with ID: ' . $draft->getId() . '<br/>';
  }

  return $drafts;
}

?>

<!-- html to show connect button-->
<div class="box">
  <div class="request">
    <?php if (isset($authUrl)): ?>
      <a class='login' href='<?php echo $authUrl; ?>'>Connect Me!</a>
    <?php else: ?>
      <a class='logout' href='?logout'>Logout</a>
    <?php endif ?>
  </div>
</div>

