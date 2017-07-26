<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Welcome extends CI_Controller
{
    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     *	- or -
     * 		http://example.com/index.php/welcome/index
     *	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     *
     * @see https://codeigniter.com/user_guide/general/urls.html
     */
    public function index()
    {
        $emails = $this->SpamEmailsm->allEmails();

        $this->load->view('welcome_message');
    }

    public function importdb()
    {
        if ($_FILES['file']['name'] != '') {
            $test = explode('.', $_FILES['file']['name']);
            $extension = end($test);
            $name = rand(100, 999).'.'.$extension;
            $location = './uploads/'.$name;
            move_uploaded_file($_FILES['file']['tmp_name'], $location);

            $file = fopen($location, 'r');
            while (!feof($file)) {
                $dsmail = fgetcsv($file);
                if (is_array($dsmail) || is_object($dsmail)) {
                    foreach ($dsmail as $email) {
                        if ($email == 'email') {
                            continue;
                        }
                        $exist = $this->SpamEmailsm->exist($email);
                        if (!$exist) {
                            $this->SpamEmailsm->addEmail($email);
                        }
                    }
                }
            }

            fclose($file);
            unlink($location);
        }
        echo 'upload successfully';
    }

    public function importemail()
    {
        if ($_FILES['file2']['name'] != '') {
            $test = explode('.', $_FILES['file2']['name']);
            $extension = end($test);
            $name = time().'.'.$extension;

            $location = './uploads/'.$name;
            $filter_file_name = './uploads/filtered_'.$_FILES['file2']['name'];
            move_uploaded_file($_FILES['file2']['tmp_name'], $location);

            $file = fopen($location, 'r');
            $fp = fopen($filter_file_name, 'w');
            $fields = array('email');
            fputcsv($fp, $fields);
            while (!feof($file)) {
                $dsmail = fgetcsv($file);
                if (is_array($dsmail) || is_object($dsmail)) {
                    foreach ($dsmail as $email) {
                        if ($email == 'email' || $email == 'Email Address' || empty($email)) {
                            continue;
                        }

                        if (strpos($email, '@') === false) {
                            continue;
                        }
                        $exist = $this->SpamEmailsm->exist($email);
                        if (!$exist) {
                            $fields = array($email);
                            fputcsv($fp, $fields);
                        } else {
                            log_message('error', $email);
                        }
                    }
                }
                // break;
            }
            echo 'upload successfully';
            fclose($file);
            fclose($fp);

            unlink($location);
        }
    }
    public function show()
    {
        $query = $this->db->query('select * from spam_emails');

        foreach ($query->result_array() as $email) {
            echo ''.$email['email'].' ';
        }
    }
    public function showallemail()
    {
        $query = $this->db->query('select * from all_emails');

        foreach ($query->result_array() as $email) {
            echo ''.$email['email'].' ';
        }
    }
}
