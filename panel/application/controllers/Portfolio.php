<?php


class Portfolio extends CI_Controller
{
    public $viewFolder = "";

    public function __construct()
    {
        parent::__construct();
        $this->viewFolder = "portfolio_v";

        $this->load->model("portfolio_model");
        $this->load->model("portfolio_image_model");
        $this->load->model("portfolio_category_model");

        if(!get_active_user())
            redirect(base_url("login"));
    }

    public function index()
    {
        $viewData = new stdClass();

        //Tablodan verilerin getirilmesi...
        $items = $this->portfolio_model->get_all(
            array(), "rank ASC"
        );

        //View'e gönderilecek değişkenlerin set edilmesi...
        $viewData-> viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "list";
        $viewData->items = $items;

        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }

    //yeni ürün sayfasına gitmek
    public function new_portfolio()
    {
        $viewData = new stdClass();

        $viewData->categories = $this->portfolio_category_model->get_all(
            array(
                "isActive" => 1
            )
        );

        $viewData-> viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "add";

        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }
    
    //yeni ürünün eklenmesi
    public function save(){
      $this->load->library("form_validation");

      $this->form_validation->set_rules("title", "Başlık", "required|trim");
      $this->form_validation->set_rules("category_id", "Kategori", "required|trim");
      $this->form_validation->set_rules("client", "Müşteri", "required|trim");
      $this->form_validation->set_rules("finishedAt", "Proje Teslim Tarihi", "required|trim");
      $this->form_validation->set_message(
          array(
              "required" => "<strong>{field}</strong> alanı doldurulmalıdır."
          )
      );
      $validate = $this->form_validation->run();

      if ($validate){

          $insert = $this->portfolio_model->add(
              array(
                  "url"             => converToSEO($this->input->post("title")),
                  "title"           => $this->input->post("title"),
                  "description"     => $this->input->post("description"),
                  "category_id"     => $this->input->post("category_id"),
                  "client"          => $this->input->post("client"),
                  "place"           => $this->input->post("place"),
                  "portfolio_url"   => $this->input->post("portfolio_url"),
                  "finishedAt"      => $this->input->post("finishedAt"),
                  "rank"            => 0,
                  "isActive"        => true,
                  "createdAt"       => date("Y-m-d H:i:s")
              )
          );

          if($insert){
              $alert = array(
                  "title"   => "Tebrikler",
                  "text"    => "İşleminiz başarılı bir şekilde gerçekleştirildi.",
                  "type"    => "success"
              );
          }
          else{
              $alert = array(
                  "title"   => "İşlem başarısız",
                  "text"    => "Lütfen zorunlu olan alanları doldurunuz!",
                  "type"    => "error"
              );
          }
             $this->session->set_flashdata("alert", $alert);
             redirect(base_url("portfolio"));

      }
      else{
          $viewData = new stdClass();

          $viewData-> viewFolder = $this->viewFolder;
          $viewData->subViewFolder = "add";
          $viewData->form_error = "true";

          $viewData->categories = $this->portfolio_category_model->get_all(
              array(
                  "isActive" => 1
              )
          );

          $alert = array(
              "title"   => "İşlem başarısız",
              "text"    => "Lütfen zorunlu olan alanları doldurunuz!",
              "type"    => "error"
          );

          $this->session->set_flashdata("alert", $alert);
          $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
          unset($_SESSION['alert']);
      }
    }

    //düzenlenecek sayfaya gitmek
    public function update_portfolio($id){
        $viewData = new stdClass();

        $item = $this->portfolio_model->get(
            array(
                "id" => $id
            )
        );

        $viewData->categories = $this->portfolio_category_model->get_all(
            array(
                "isActive" => 1
            )
        );

        $viewData-> viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "update";
        $viewData->item = $item;

        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }

    //düzenlenen veriyi veri tabanına kaydetmek
    public function update($id){
        $this->load->library("form_validation");

        $this->form_validation->set_rules("title", "Başlık", "required|trim");
        $this->form_validation->set_rules("category_id", "Kategori", "required|trim");
        $this->form_validation->set_rules("client", "Müşteri", "required|trim");
        $this->form_validation->set_rules("finishedAt", "Proje Teslim Tarihi", "required|trim");
        $this->form_validation->set_message(
            array(
                "required" => "<strong>{field}</strong> alanı doldurulmalıdır."
            )
        );

        $validate = $this->form_validation->run();

        if ($validate){

            $update = $this->portfolio_model->update(
                array(
                    "id" => $id,
                ),
                array(
                    "url"             => converToSEO($this->input->post("title")),
                    "title"           => $this->input->post("title"),
                    "description"     => $this->input->post("description"),
                    "category_id"     => $this->input->post("category_id"),
                    "client"          => $this->input->post("client"),
                    "place"           => $this->input->post("place"),
                    "portfolio_url"   => $this->input->post("portfolio_url"),
                    "finishedAt"      => $this->input->post("finishedAt")
                )
            );

            if($update){
                $alert = array(
                    "title"   => "Tebrikler",
                    "text"    => "İşleminiz başarılı bir şekilde gerçekleştirildi.",
                    "type"    => "success"
                );

            }
            else{
                $alert = array(
                    "title"   => "İşlem başarısız",
                    "text"    => "Lütfen zorunlu olan alanları doldurunuz!",
                    "type"    => "error"
                );
            }
            $this->session->set_flashdata("alert", $alert);
            redirect(base_url("portfolio"));

        }
        else{
            $viewData = new stdClass();

            $item = $this->portfolio_model->get(
                array(
                    "id" => $id
                )
            );

            $viewData->categories = $this->portfolio_category_model->get_all(
                array(
                    "isActive" => 1
                )
            );

            $viewData-> viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "update";
            $viewData->form_error = "true";
            $viewData->item = $item;

            $alert = array(
                "title"   => "İşlem başarısız",
                "text"    => "Lütfen zorunlu olan alanları doldurunuz!",
                "type"    => "error"
            );
            $this->session->set_flashdata("alert", $alert);
            $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
            unset($_SESSION['alert']);
        }
    }

    public function delete($id){
        //ürün silindiği zaman resmi silmeyi de eklemeliyim....
        $delete = $this->portfolio_model->delete(
          array(
              "id" => $id
          )
        );

        if($delete){
            $alert = array(
                "title"   => "Tebrikler",
                "text"    => "İşleminiz başarılı bir şekilde gerçekleştirildi.",
                "type"    => "success"
            );

        }
        else{
            $alert = array(
                "title"   => "İşlem başarısız",
                "text"    => "Lütfen zorunlu olan alanları doldurunuz!",
                "type"    => "error"
            );
        }

        $this->session->set_flashdata("alert", $alert);
        redirect(base_url("portfolio"));
    }

    public function imageDelete($id, $parent_id){

        $fileName = $this->portfolio_image_model->get(
            array(
                "id"  => $id
            )
        );

        $delete = $this->portfolio_image_model->delete(
          array(
              "id" => $id
          )
        );

        if($delete){
            unlink("uploads/{$this->viewFolder}/$fileName->img_url");

            $alert = array(
                "title"   => "Tebrikler",
                "text"    => "İşleminiz başarılı bir şekilde gerçekleştirildi.",
                "type"    => "success"
            );
            $this->session->set_flashdata("alert", $alert);
            redirect(base_url("portfolio/image_form/$parent_id"));
        }
        else{
            $alert = array(
                "title"   => "İşlem başarısız",
                "text"    => "Lütfen zorunlu olan alanları doldurunuz!",
                "type"    => "error"
            );

            $this->session->set_flashdata("alert", $alert);
            redirect(base_url("portfolio/image_form/$parent_id"));
            unset($_SESSION['alert']);
        }

    }

    public function isActiveSetter($id){

        if($id){

            $isActive = ($this->input->post("data") === "true") ? 1 : 0;

            $this->portfolio_model->update(
                array(
                    "id" => $id,
                ),
                array(
                    "isActive" => $isActive
                )
            );
        }

    }

    public function imageIsActiveSetter($id){

        if($id){

            $isActive = ($this->input->post("data") === "true") ? 1 : 0;

            $this->portfolio_image_model->update(
                array(
                    "id" => $id,
                ),
                array(
                    "isActive" => $isActive
                )
            );
        }

    }

    public function rankSetter(){
        $data = $this->input->post("data");

        parse_str($data, $order);
        $items = $order["ord"];

        foreach ($items as $rank => $id){
            $this->portfolio_model->update(
                array(
                    "id"        =>  $id,
                    "rank !="   =>  $rank
                ),
                array(
                    "rank" => $rank
                )
            );
        }
    }

    public function imageRankSetter(){
        $data = $this->input->post("data");

        parse_str($data, $order);
        $items = $order["ord"];

        foreach ($items as $rank => $id){
            $this->portfolio_image_model->update(
                array(
                    "id"        =>  $id,
                    "rank !="   =>  $rank
                ),
                array(
                    "rank" => $rank
                )
            );
        }
    }

    public function image_form($id){
        $viewData = new stdClass();

        $item = $this->portfolio_model->get(
            array(
                "id" => $id
            )
        );

        $viewData->item_images =  $this->portfolio_image_model->get_all(
          array(
              "portfolio_id" => $id,
          ),
            "rank ASC"
        );


        $viewData-> viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "image";
        $viewData->item = $item;

        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

    }

    public function image_upload($id){

        $file_name = converToSEO(pathinfo($_FILES["file"]["name"], PATHINFO_FILENAME)). "." . pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
        $config["allowed_types"] = "jpg|jpeg|png";
        $config["upload_path"] = "uploads/$this->viewFolder/";
        $config["file_name"] = $file_name;

        $this->load->library("upload", $config);
        $upload = $this->upload->do_upload("file");


        if($upload){

            $uploaded_file = $this->upload->data("file_name");

            $this->portfolio_image_model->add(
                array(
                    "img_url"       => $uploaded_file,
                    "rank"          => 0,
                    "isActive"      => 1,
                    "createdAt"     => date("Y-m-d H:i:s"),
                    "portfolio_id"    => $id
                )
            );
        }
        else{
                echo "islem basarisiz";
        }

    }

    public function refresh_image_list($id){
        $viewData = new stdClass();

        $viewData-> viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "image";

        $viewData->item_images =  $this->portfolio_image_model->get_all(
            array(
                "portfolio_id" => $id
            )
        );

        $render_html = $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/render_elements/image_list_v", $viewData, true);

        echo $render_html;


    }

    public function isCoverSetter($id, $parent_id){
        if($id && $parent_id){
            $isCover = ($this->input->post("data") == "true") ? 1 : 0;

            //bu kayıt kapak fotoğrafı olacaktır dediğin..
            $this -> portfolio_image_model->update(
                array(
                    "id"            => $id,
                    "portfolio_id"    => $parent_id
                ),
                array(
                    "isCover"       => $isCover
                )
            );

            //kapak olmayan kayıtlar kapalı hale getiriliyor.
            $this->portfolio_image_model->update(
                array(
                    "id !="         => $id,
                    "portfolio_id"    => $parent_id
                ),
                array(
                    "isCover"       => 0
                )
            );

            $viewData = new stdClass();

            $viewData-> viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "image";

            $viewData->item_images =  $this->portfolio_image_model->get_all(
                array(
                    "portfolio_id" => $parent_id
                ),
                    "rank ASC"
            );

            $render_html = $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/render_elements/image_list_v", $viewData, true);

            echo $render_html;



        }
    }

}
