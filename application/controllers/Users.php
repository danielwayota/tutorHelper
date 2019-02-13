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
                    'email' => trim($this->input->post('email')),
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
                        $this->show_notification('Sesión iniciada');
                        redirect('');
                    }
                    else
                    {
                        $this->load_login_with_error('Este usuario está desactivado');
                    }
                }
                else
                {
                    $this->load_login_with_error('Credenciales no válidos');
                }
            }
        }

        /**
         * Renders the login page and send an error.
         */
        public function load_login_with_error($error)
        {
            $this->show_notification($error, 'error');

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

            $this->show_notification('Sesión cerrada');
            redirect('users/login');
        }

        // =================================
        // Administrator stuff
        // =================================

        public function list()
        {
            $this->check_superadmin_session();

            $users = $this->user_model->get_regular_users();

            $data['users'] = $users;

            $this->load_header_and_menu();
            $this->load->view('users/admin_list.php', $data);
            $this->load_footer();
        }

        /**
         * User creation page
         */
        public function create()
        {
            $this->check_superadmin_session();

            // Validation stuff
            $this->form_validation->set_rules('name', 'Name', 'required');
            $this->form_validation->set_rules(
                'email',
                'Email',
                'required|valid_email|callback_check_email_exists',
                array(
                    'required' => 'El Email es requerido.',
                    'valid_email' => 'No es una dirección de Email válida',
                    'check_email_exists' => 'Email en uso.'
                )
            );
            $this->form_validation->set_rules('password', 'Password', 'required',
                array('required' => 'La contraseña es requerida.')
            );
            $this->form_validation->set_rules('password2', 'Confirm Password', 'matches[password]',
                array('matches' => 'Las contraseñas no coinciden')
            );

            // Load sended data if there is any.
            $user_data = array(
                'Name' => $this->input->post('name'),
                'Email' => trim($this->input->post('email')),
                'Comments' => $this->input->post('comments')
            );

            $data['user'] = $user_data;

            // Do stuff
            if ($this->form_validation->run() == FALSE)
            {
                $this->load_header_and_menu();
                $this->load->view('users/admin_create.php', $data);
                $this->load_footer();
            }
            else
            {
                $user_data = array(
                    'Name' => $this->input->post('name'),
                    'Email' => trim($this->input->post('email')),
                    'Password' => md5($this->input->post('password'))
                );

                $extra_data = array(
                    'Comments' => $this->input->post('comments'),
                    'PriceOverride' => 0
                );

                if ($this->input->post('use-custom-price'))
                {
                    $extra_data['PriceOverride'] = $this->input->post('custom-price');
                }

                $this->user_model->create_regular_user($user_data, $extra_data);

                // Feedback message
                $this->show_notification('Usuario '.$user_data['Name'].' creado');
                redirect('users/list');
            }
        }

        /** 
         * Renders the user edit page.
         */
        public function edit($id)
        {
            $this->check_superadmin_session();

            // Validation stuff
            $this->form_validation->set_rules('name', 'Name', 'required');

            // Validate password only if they are not empty
            if (
                $this->input->post('password') !== '' ||
                $this->input->post('password2') !== ''
                )
            {
                $this->form_validation->set_rules('password', 'Password', 'required');
                $this->form_validation->set_rules('password2', 'Confirm Password', 'matches[password]',
                    array('matches' => 'Las contraseñas no coinciden')
                );
            }

            // Do stuff
            if ($this->form_validation->run() == FALSE)
            {
                // Load the actual user data.
                $user_data = $this->user_model->get_user_with_data($id);
    
                if (empty($user_data))
                {
                    $this->show_notification('Usuario no encontrado.', 'error');
                    redirect('users/list');
                }
    
                $data['user'] = $user_data;
            }
            else
            {
                // User base data
                $user_data = array(
                    'Name' => $this->input->post('name'),
                    'Enabled' => $this->input->post('enabled') ? 1 : 0
                );
                
                // The password is not required
                $password = $this->input->post('password');
                if ($password !== '')
                {
                    $user_data['Password'] = md5($password);
                }
                
                // Extra data
                $extra_data = array(
                    'Comments' => $this->input->post('comments'),
                    'PriceOverride' => 0
                );

                if ($this->input->post('use-custom-price'))
                {
                    $extra_data['PriceOverride'] = $this->input->post('custom-price');
                }

                $this->user_model->update_regular_user($id, $user_data, $extra_data);

                
                $this->show_notification('Usuario guardado');
                $data['user'] = $this->user_model->get_user_with_data($id);
            }

            $this->load_header_and_menu();
            $this->load->view('users/admin_edit.php', $data);
            $this->load_footer();
        }

        /**
         * Removes a single page.
         */
        public function delete($id)
        {
            $this->check_superadmin_session();

            $status = $this->user_model->delete_regular_user($id);
            if ($status)
            {
                $this->show_notification('Usuario borrado');
            }
            else
            {
                $this->show_notification('No se pudo borrar', 'error');
            }

            redirect('users/list');
        }

        // =========================================
        // Private functions
        // =========================================

        /**
         * Check if email exists
         */
        function check_email_exists($email)
        {
            if ($this->user_model->check_email_exists($email))
            {
                return true;
            }
            else
            {
                return false;
            }
        }
    }