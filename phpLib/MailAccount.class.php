<?php
/**
 * Class       : MailAccount
 * Description : 
 *
 */

class MailAccount {
  protected $server;
  protected $type;
  protected $port;
  protected $user;
  protected $password;
  protected $imap;

  public function __construct($mb) {
    $this->server = $mb['server'];
    $this->type = $mb['type'];
    $this->port = $mb['port'];
    $this->user = $mb['user'];
    $this->password = $mb['password'];
  }

  public function openMailbox($mailbox) {
    $str = '{' . $this->server;
    if ($this->type == 'POP3') { $str .= '/pop3'; }
    $str .= ':' . $this->port . '}' . $mailbox;

    $this->imap = imap_open($str, $this->user, $this->password);
    if ($this->imap) { return true; } else { return false; }
  }

  public function getHeaders() {
    return imap_headers($this->imap);
  }

  public function fetchHeader($n) {
    return imap_fetchheader($this->imap, $n);
  }

  public function deleteEmail() {
    /* imap_delete(); */
  }

  public function expunge() {
    /* imap_expunge(); */
  }
}
?> 
