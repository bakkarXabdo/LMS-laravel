@extends('layouts.master')

@section('PageTitle') About @endsection

@section('content')
<section class="py-10 text-center container align-items-center">
    <div class="jumbotron" id="content" tabindex="-1">
        <div class="container">
            <h1 class="fw-light">About the Site</h1>
        </div>
    </div>
</section>
<div class="container bs-docs-container">
    <!-- info
================================================== -->
    <div class="bs-docs-section">
        <h1 id="info" class="page-header">General info</h1>

        <p class="lead">LMS was created in 2020 by <strong>Bekkouche Eboubaker</strong> and <strong>Darbeida
                Abdelhak</strong>.</p>
        <p class="">LMS is a Library Management System for the Faculty of Science Exact and Computer Science, it's
            contains all the available books in the faculty library . <br>
            It's meant to make the book borrowing as easy as possible for the students and Librarian .</p>
    </div>
    <!-- how-to-use
================================================== -->
    <div class="bs-docs-section">
        <h1 id="how-to-use" class="page-header">How to Use</h1>

        <p class="lead">The use of LMS is very simple:</p>
        <ul>
            <li>Search for a book.</li>
            <li>Take the book code and give it to the Librarian.</li>
            <li>Take the book for the mentioned period.</li>
        </ul>
    </div>
    <!-- Team
================================================== -->
    <div class="bs-docs-section">
        <h1 id="team" class="page-header">Team</h1>

        <p class="lead">
            The team members who worked on this project are <strong>Bekkouche Eboubaker</strong> and <strong>Darbeida
                Abdelhak</strong>, Students at university of Zian Achor Djelfa.
            Faculty of Science Exact and Computer Science, Speciality Developing Web and Mobile Apps.</p>
    </div>
    <div style="display: flex;align-items: center;justify-content: center;">
        <div style="" class="col-md-4">
            <a style="display: flex;flex-direction: column;justify-items: center;align-items: center;"
                href="https://web.facebook.com/aboubakkar.bekkouche/">
                <div style="border-radius: 50%;width:300px;height:300px">
                    <div style="border-radius: 50%;
                    width: 300px;
                    height: 300px;
                    background: url(images/about/1.jpg);
                    background-position: center;
                    background-size: cover;
                    background-repeat: no-repea"></div>
                </div>
                <p style="font-size: 2rem; color:mediumblue;margin:0 auto">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 167.657 167.657" style="enable-background:new 0 0 167.657 167.657;" xml:space="preserve" width="24px"><g><path style="fill: #0b05ff;" d="M83.829,0.349C37.532,0.349,0,37.881,0,84.178c0,41.523,30.222,75.911,69.848,82.57v-65.081H49.626   v-23.42h20.222V60.978c0-20.037,12.238-30.956,30.115-30.956c8.562,0,15.92,0.638,18.056,0.919v20.944l-12.399,0.006   c-9.72,0-11.594,4.618-11.594,11.397v14.947h23.193l-3.025,23.42H94.026v65.653c41.476-5.048,73.631-40.312,73.631-83.154   C167.657,37.881,130.125,0.349,83.829,0.349z"/></g></svg>
                    <strong>Bekkouche Eboubaker</strong>
                </p>
            </a>

        </div><!-- /.col-lg-4 -->
        <div class="col-md-4">
            <a style="display: flex;flex-direction: column;justify-items: center;align-items: center;"
                href="https://web.facebook.com/ABDELHAK.DARBEIDA/">
                <div style="border-radius: 50%;width:300px;height:300px">
                    <div style="border-radius: 50%;
                    width: 300px;
                    height: 300px;
                    background: url(images/about/2.jpg);
                    background-position: center;
                    background-size: cover;
                    background-repeat: no-repea"></div>
                </div>
                <p style="font-size: 2rem; color:mediumblue;margin:0 auto">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 167.657 167.657" style="enable-background:new 0 0 167.657 167.657;" xml:space="preserve" width="24px"><g><path style="fill: #0b05ff;" d="M83.829,0.349C37.532,0.349,0,37.881,0,84.178c0,41.523,30.222,75.911,69.848,82.57v-65.081H49.626   v-23.42h20.222V60.978c0-20.037,12.238-30.956,30.115-30.956c8.562,0,15.92,0.638,18.056,0.919v20.944l-12.399,0.006   c-9.72,0-11.594,4.618-11.594,11.397v14.947h23.193l-3.025,23.42H94.026v65.653c41.476-5.048,73.631-40.312,73.631-83.154   C167.657,37.881,130.125,0.349,83.829,0.349z"/></g></svg>
                    <strong>Darbeida Abdelhak</strong>
                </p>
            </a>
        </div>
    </div>
</div>
@endsection
