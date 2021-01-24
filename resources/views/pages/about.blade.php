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

      <p class="lead">LMS was created in 2020 by <strong>Bekkouche Eboubaker</strong> and <strong>Darbeida Abdelhak</strong>.</p>
      <p class="">LMS is a Library Management System for the Faculty of Science Exact and Computer Science, it's contains all the available books in the faculty library . <br>
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

      <p class="lead">The team member who worked on this project are <strong>Bekkouche Eboubaker</strong> and <strong>Darbeida Abdelhak</strong> Students at university of Zian Achor Djelfa. 
        study in faculty of Science Exact and Computer Science in Speciality Developing Web and Mobile Apps.</p>

      <div class="list-group bs-team">
        
        <div class="list-group-item">
          <a class="team-member" href="https://web.facebook.com/aboubakkar.bekkouche/">
            {{-- <img src="" alt="" width="32" height="32"> --}}
            <strong>Bekkouche Eboubaker</strong>
          </a>
        </div>

        <div class="list-group-item">
          <a class="team-member" href="https://web.facebook.com/ABDELHAK.DARBEIDA/">
            {{-- <img src="" alt="" width="32" height="32"> --}}
            <strong>Darbeida Abdelhak</strong>
          </a>
        </div>
      </div>
    </div>
</div>
@endsection