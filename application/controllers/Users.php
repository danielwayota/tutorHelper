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
                
                // Try to match the credentials with some user.
                $user_data = $this->user_model->login($user_credentials);

                // Check the login status
                if (!empty($user_data))
                {
                    if ($user_data['Enabled'])
                    {
                        // Stores the user data
                        $session = array(
                            'IdUser' => $user_data['IdUser'],
                            'username' => explode('@', $user_data['Email'])[0],
                            'IsSuperAdmin' => $user_data['IsSuperAdmin'],
                            'logged_in' => true
                        );
                        
                        $this->session->set_userdata($session);
                        $this->session->set_flashdata('notification', 'Sessión iniciada.');
                        redirect('');
                    }
                    else
                    {
                        $this->load_login_with_error('Este usuario está desactivado');
                    }
                }
                else
                {
                    $this->load_login_with_error('Credenciales inválidos.');
                }
            }
        }

        /**
         * Renders the login page and send an error.
         */
        public function load_login_with_error($error)
        {
            $this->session->set_flashdata('notification', $error);
            $this->session->set_flashdata('notification_color', 'deep-orange lighten-1');

            $this->load_header_and_menu();
            $this->load->view('users/login.php');
            $this->load_footer();
        }

        /**
         * Just clears the user data
         */
        public function logout()
        {
            $this->clear_user_data();

            $this->session->set_flashdata('notification', 'Sessión cerrada.');
            redirect('users/login');
        }
    }