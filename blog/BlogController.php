<?php

    include_once $_SERVER["DOCUMENT_ROOT"]."/config/connection.php";
    include_once $_SERVER["DOCUMENT_ROOT"]."/lib/Helper.php";
    include_once $_SERVER["DOCUMENT_ROOT"]."/blog/BlogModel.php";

    class BlogController
    {
        public $model = null;

        public function __construct()
        {
            $this -> model = new BlogModel();
        }

        public function AllPosts()
        {
            $viewBag = [];

            $posts = $this -> model -> GetAllPosts();

            foreach ($posts as $key => $post) {
                $urlTitle = str_replace(" ", "-", $post['Title']);

                $appendedPost = array(
                    'Title' => $post['Title'],
                    'DateCreated' => $post['DateCreated'],
                    'Content' => $post['Content'],
                    'UrlTitle' => $urlTitle
                );

                array_push($viewBag, $appendedPost);
            }

            return $viewBag;
        }

        public function PostsByTag($tag)
        {
            return $this -> model -> GetPostsByTag($tag);
        }

        public function PostsByDate($month, $year)
        {
            $viewBag = [];
            
            $date = new DateTime($year . $month . "01");
            $archive = $date->format('Y-m-d');

            $posts = $this -> model -> GetAllPosts($archive);

            foreach ($posts as $key => $post) {
                $urlTitle = str_replace(" ", "-", $post['Title']);

                $appendedPost = array(
                    'Title' => $post['Title'],
                    'DateCreated' => $post['DateCreated'],
                    'Content' => $post['Content'],
                    'UrlTitle' => $urlTitle
                );

                array_push($viewBag, $appendedPost);
            }

            return $viewBag;
        }

        public function PostById($id)
        {

        }

        public function PostByTitle($title)
        {
            $title = str_replace("-", " ", $title);

            return $this -> model -> GetPostByTitle(trim($title));
        }

        public function TagCloud()
        {
             return $this -> model -> GetTagCloud();
        }

        public function ArchiveDates()
        {
             $postDates = $this -> model -> GetArchiveDates();

             foreach ($postDates as $key => $date) {
                 
             }

             return $dates;
        }
    }
?>