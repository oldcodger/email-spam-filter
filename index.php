<?php
require_once('phpLib/MailAccount.class.php');
?> 
<!DOCTYPE html> 

<html>
<head>
<meta charset="utf-8">
<title>Email Spam filter</title>
</head>

<body>

<h1>E-Mail Accounts</h1>
<?php
$mailboxes = array();
try {
  $mailboxes['Example.com'] = new MailAccount(
      array(
        'server'   => 'pop.example.com',
        'type'     => 'POP3',
        'port'     => 110,
        'user'     => 'user@example.com',
        'password' => 'mypassword'
      )
    );

  foreach ($mailboxes as $name => $mailbox) {
    echo '<h2>'. $name .'</h2>';
    $result = $mailbox->openMailbox('INBOX');

    if ($result) {
      $d = FALSE;
      $k = sizeof($mailbox->getHeaders());

      for ($n = 1; $n <= $k; $n++) {
        $header = $mailbox->fetchHeader($n);

        $markers = array('x-rbl-warning', 'spamcop.net', 'abuseat.org');
        $spam = FALSE;
        foreach ($markers as $marker) {
          $i = stripos($header, $marker);
          if ($i !== false) {
            $spam = TRUE;
          }
        }
        if ($spam) {
          echo '*** Probable spam! ***';
          echo '<pre>'. $header .'</pre>';
          //imap_delete($imap, $n); Deliberately commented out. Activate suitable code when you are comfortable doing so.
          $d = TRUE;
        }
      }
      if ($d == TRUE) { echo '<p>SPAM! Expunge()</p>'; /*imap_expunge($imap);*/ } else { echo '<p>No spam detected</p>'; }
    }
  }
}
catch (Exception $e) {
	echo ('Error. '. $e->getMessage());
}
?> 

</body>
</html>
