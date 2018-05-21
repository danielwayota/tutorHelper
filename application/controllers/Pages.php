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
                $page = array(
                    'IdPage' => 0,
                    'Title' => '',
                    'Content' => '<h5 class="center-align"> - No hay páginas creadas - </h5>'
                );
            }

            $this->load_header_and_menu(array(
                'selected_page_id' => $page['IdPage']
            ));

            $data['page'] = $page;
    
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
            $this->check_user_session();

            $this->load_header_and_menu();

            $data['pages'] = $this->pages;
            $this->load->view('pages/admin_list.php', $data);

            $this->load_footer();
        }

        /**
         * Renders the page edit page.
         */
        public function edit($id)
        {
            $this->check_user_session();

            $this->load_header_and_menu();

            $this->load_footer();
        }

        /**
         * Removes a single page.
         */
        public function delete($id)
        {
            $this->check_user_session();

            $status = $this->page_model->delete_page($id);
            if ($status)
            {
                $this->session->set_flashdata('notification', 'Página borrada.');
            }
            else
            {
                $this->session->set_flashdata('notification', 'No se pudo borrar');
            }

            redirect('pages/list');
        }
    }