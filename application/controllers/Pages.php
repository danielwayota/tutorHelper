<?php
    class Pages extends TH_Controller
    {
        /**
         * Just calls the view function with default parameters
         */
        public function index()
        {
            $this->view();
        }
        
        /**
         * Renders the default page or a selected one.
         * @param: id - The page id in the database
         */
        public function view($id = 0)
        {
            $page = $this->page_model->get_single_page($id);
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
    }