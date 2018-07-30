<?php
    class Pages extends TH_Controller
    {
        /**
         * Just calls the view function with default parameters.
         */
        public function index()
        {
            $this->view();
        }
        
        /**
         * Renders the default page or a selected one.
         * @param: id - The page id in the database.
         */
        public function view($id = 0)
        {
            // Get the requested page.
            $page = $this->page_model->get_single_page($id);

            // If there is no page, generate an advice.
            if ($page === NULL) {
                if ($id !== 0)
                {
                    redirect('');
                }
                else
                {
                    $page = array(
                        'IdPage' => 0,
                        'Title' => '',
                        'Content' => '<h5 class="center-align"> - No hay páginas creadas - </h5>'
                    );
                }
            }

            $this->load_header_and_menu(array(
                'selected_page_id' => $page['IdPage']
            ));

            $data['PAGE'] = $page;
    
            $this->load->view('pages/single.php', $data);
            $this->load_footer();
        }

        // =================================
        // Administrator stuff
        // =================================

        /**
         * Renders the pages management page.
         */
        public function list()
        {
            $this->check_superadmin_session();

            $this->load_header_and_menu();

            $data['PAGES'] = $this->pages;
            $this->load->view('pages/admin_list.php', $data);

            $this->load_footer();
        }

        /**
         * Render the creation page.
         */
        public function create()
        {
            $this->check_superadmin_session();

            // Validation rules
            $this->form_validation->set_rules('title', 'Título', 'required',
                array('required' => 'Al menos un título es requerido.')
            );

            if ($this->form_validation->run() === FALSE)
            {
                $this->load_header_and_menu();
                $this->load->view('pages/admin_create.php');
                $this->load_footer();
            }
            else
            {
                $page_data = array(
                    'Title' => $this->input->post('title'),
                    'Content' => $this->input->post('content'),
                    'Position' => $this->input->post('position')
                );

                $this->page_model->create_page($page_data);

                $this->show_notification('Página '.$page_data['Title'].' creada');
                redirect('pages/list');
            }
        }

        /**
         * Renders the page edit page.
         */
        public function edit($id)
        {
            $this->check_superadmin_session();

            // Validation rules
            $this->form_validation->set_rules('title', 'Título', 'required',
                array('required' => 'Al menos un título es requerido.')
            );

            if ($this->form_validation->run() === FALSE)
            {
                // ???
            }
            else
            {
                $page_data = array(
                    'Title' => $this->input->post('title'),
                    'Position' => $this->input->post('position'),
                    'Content' => $this->input->post('content')
                );

                $this->page_model->update_page($id, $page_data);

                $this->show_notification('Cambios aplicados.');
            }

            // Load the page data.
            $page = $this->page_model->get_single_page($id);

            if (empty($page))
            {
                $this->show_notification('Página no encontrada.', 'error');
                redirect('pages/list');
            }

            $data['PAGE'] = $page;

            $this->load_header_and_menu();
            $this->load->view('pages/admin_edit.php', $data);
            $this->load_footer();
        }

        /**
         * Removes a single page.
         */
        public function delete($id)
        {
            $this->check_superadmin_session();

            $status = $this->page_model->delete_page($id);
            if ($status)
            {
                $this->show_notification('Página borrada.');
            }
            else
            {
                $this->show_notification('No se pudo borrar');
            }

            redirect('pages/list');
        }
    }