<?php
    class Profile extends TH_Controller
    {
        /**
         * Displays the current user data
         */
        public function index()
        {
            $this->check_user_session();
            $this->load_header_and_menu();

            $id = $this->session->userdata('IdUser');
            $is_superuser = $this->session->userdata('IsSuperAdmin');
            if ($is_superuser)
            {
                $data['user'] = $this->user_model->get_user($id);
            }
            else
            {
                $data['user'] = $this->user_model->get_user_with_data($id);
            }

            $this->load->view('profile/profile.php', $data);

            $this->load_footer();
        }

        /**
         * Performs the update for the current user
         */
        public function update()
        {
            $this->check_user_session();

            $user_id = $this->session->userdata('IdUser');
            $pre_user_data = $this->user_model->get_user($user_id);
            $user_data = $pre_user_data;

            // Setup validation
            $this->form_validation->set_rules('name', 'Name', 'required');
            
            // Validate email if it's diferent.
            if ($this->input->post('email') !== $pre_user_data['Email'])
            {
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
            }

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

            // No validation or wrong validation.
            if ($this->form_validation->run() === TRUE)
            {
                // User base data
                $user_data = array(
                    'Name' => $this->input->post('name'),
                    'Email' => $this->input->post('email')
                );

                $session = array(
                    'IdUser' => $user_id,
                    'username' => explode('@', $user_data['Email'])[0],
                    'IsSuperAdmin' => $pre_user_data['IsSuperAdmin'],
                    'logged_in' => true
                );
                $this->session->set_userdata($session);
                
                // The password is not required
                $password = $this->input->post('password');
                if ($password !== '')
                {
                    $user_data['Password'] = md5($password);
                }

                $this->user_model->update_user($user_id, $user_data);

                $this->show_notification('Perfil actualizado');
            }
            else
            {
                // In case of failed validation, keep the input data.
                $user_data = array(
                    'Name' => $this->input->post('name') ? $this->input->post('name') : $pre_user_data['Name'],
                    'Email' => $this->input->post('email') ? $this->input->post('email') : $pre_user_data['Email']
                );
            }

            // Show the updated porfile and errors.
            $this->load_header_and_menu();

            $data['user'] = $user_data;

            $this->load->view('profile/profile.php', $data);

            $this->load_footer();
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
?>