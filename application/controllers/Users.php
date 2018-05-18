<?php

    class Users extends TH_Controller
    {
        /**
         * Login functionality
         */
        public function login()
        {
            // Set the validation rules.
            $this->form_validation->set_rules('email', 'Email', 'required',
                array('required' => 'El Email es requerido.')
            );
            $this->form_validation->set_rules('password', 'Password', 'required',
                array('required' => 'La contraseña es requerida.')
            );

            // No validation or wrong validation.
            if ($this->form_validation->run() === FALSE)
            {
                $this->load_header_and_menu();
                $this->load->view('users/login.php');
                $this->load_footer();
            }
            // Valid data.
            else
            {
                $user_credentials = array(
                    'email' => $this->input->post('email'),
                    'password' => md5($this->input->post('password'))
                );
                
                $user_data = $this->user_model->login($user_credentials);


                if (!empty($user_data))
                {
                    $session = array(
                        'IdUser' => $user_data['IdUser'],
                        'username' => explode('@', $user_data['Email'])[0],
                        'logged_in' => true
                    );
                    
                    $this->session->set_userdata($session);
                    // $this->session->set_flashdata('notification', '');
                    redirect('');
                }
                else
                {
                    $this->load_header_and_menu();
                    $this->load->view('users/login.php');
                    $this->load_footer();
                }
            }
        }

        /**
         * Just clears the user data
         */
        public function logout()
        {
            // Unset user data
            $this->session->unset_userdata('IdUser');
            $this->session->unset_userdata('username');
            $this->session->unset_userdata('logged_in');

            $this->session->set_flashdata('notification', 'Loged out');
            redirect('');
        }
    }