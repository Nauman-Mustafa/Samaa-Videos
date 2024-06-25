<template>
    <nav class="navbar navbar-expand-lg top-navbar">
      <div class="container-fluid">
        <a class="navbar-brand" href="#">
          <!-- <img src="logo.png" alt="SAMAA" class="logo"> -->
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link watch-live" href="#">Watch Live</a>
            </li>
          </ul>
          <form class="d-flex search-container">
            <input class="form-control" type="search" placeholder="Search Videos" aria-label="Search">
          </form>
          <div class="language-switcher">
  <a class="nav-link" href="#">English</a>
  <div class="divider"></div>
  <a class="nav-link" href="#">اردو</a>
</div>
        </div>
      </div>
    </nav>
  </template>
  
  <script>
  export default {
    name: 'TopNavbar'
  }
  </script>
  
  <style scoped>
  .top-navbar {
    background-color: #003366;
    color: white;
    position: sticky;
    top: 0;
  z-index: 1000;
  }
  .logo {
    height: 40px;
  }
  .navbar-toggler {
    border-color: rgba(255, 255, 255, 0.1);
  }
  .navbar-toggler-icon {
    background-image: url("data:image/svg+xml,..."); /* Add SVG icon here */
  }
  .watch-live {
    background-color: #ff0000;
    color: white;
    padding: 5px 10px;
    border-radius: 5px;
  }
  .search-container {
    flex: 1;
    margin: 0 387px;
  }
  .language-switcher {
  display: flex;
  align-items: center;
}

.language-switcher .nav-link {
  color: white;
  padding: 0 10px;
}

.language-switcher .divider {
  width: 1px;
  height: 40px;
  background-color: white;
  margin: 0 10px;
}

  </style>
  