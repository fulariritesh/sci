<?php get_header(); ?>

  <section class="container-fluid findtalent-topbar">
    <div class="container px-0 ">
      <div class="row">
        <div class="col-8 pt-3">
          <!-- Nav tabs -->
          <ul class="nav findtalent-tabs">
            <li class="nav-item">
              <a class="nav-link select" data-toggle="tab" href="">Find Talent</a>
            </li>
          </ul>
        </div>
        <div class="col-4 pt-3 scibreadcrumb">
          <ul class="nav float-right">
            <li class="nav-item">
              <a class="nav-link select" data-toggle="tab" href="#category-search">All Categories</a>
            </li>
          </ul>
        </div>
      </div>

      <div class="tab-content">
        <div class="tab-pane container active category-search p-3" id="category-search">
          <h5 class="text-uppercase">All Categories</h5>
          <div class="row m-0">
            <div class="col-6 col-lg-3 mb-2  px-0">
              <div class="row mx-1 shadow-sm ">
                <div class="col-4 py-2"><img src="./images/actors.png" alt="Actors Category" /></div>
                <div class="col-8 py-2 px-0">
                  <span class="text-uppercase d-block">Actors</span>
                  <span class="d-block cat-num">(8)</span>
                </div>
              </div>
            </div>

            <div class="col-6 col-lg-3 mb-2  px-0">
              <div class="row mx-1 shadow-sm">
                <div class="col-4 py-2"><img src="./images/musicians.png" alt="Musicians Category" /></div>
                <div class="col-8 py-2 px-0">
                  <span class="text-uppercase d-block">Musicians</span>
                  <span class="d-block cat-num">(8)</span>
                </div>
              </div>
            </div>

            <div class="col-6 col-lg-3 mb-2  px-0">
              <div class="row mx-1 shadow-sm">
                <div class="col-4 py-2"><img src="./images/film-crew.png" alt="Film Crew Category" /></div>
                <div class="col-8 py-2 px-0">
                  <span class="text-uppercase d-block">Film Crew</span>
                  <span class="d-block cat-num">(8)</span>
                </div>
              </div>
            </div>

            <div class="col-6 col-lg-3 mb-2  px-0">
              <div class="row mx-1 shadow-sm ">
                <div class="col-4 py-2"><img src="./images/photographers.png" alt="Photographers Category" /></div>
                <div class="col-8 py-2 px-0">
                  <span class="text-uppercase d-block">Photographers</span>
                  <span class="d-block cat-num">(8)</span>
                </div>
              </div>
            </div>

            <div class="col-6 col-lg-3 mb-2  px-0">
              <div class="row mx-1 shadow-sm ">
                <div class="col-4 py-2"><img src="./images/influencers.png" alt="Influencers Category" /></div>
                <div class="col-8 py-2 px-0">
                  <span class="text-uppercase d-block">Influencers</span>
                  <span class="d-block cat-num">(8)</span>
                </div>
              </div>
            </div>

            <div class="col-6 col-lg-3 mb-2  px-0">
              <div class="row mx-1 shadow-sm ">
                <div class="col-4 py-2"><img src="./images/dancers.png" alt="Dancers Category" /></div>
                <div class="col-8 py-2 px-0">
                  <span class="text-uppercase d-block">Dancers</span>
                  <span class="d-block cat-num">(8)</span>
                </div>
              </div>
            </div>

            <div class="col-6 col-lg-3 mb-2 px-0">
              <div class="row mx-1 shadow-sm ">
                <div class="col-4 py-2"><img src="./images/enter.png" alt="Entertainers Category" /></div>
                <div class="col-8 py-2 px-0">
                  <span class="text-uppercase d-block">Entertainers</span>
                  <span class="d-block cat-num">(8)</span>
                </div>
              </div>
            </div>

            <div class="col-6 col-lg-3 mb-2 px-0">
              <div class="row mx-1 shadow-sm ">
                <div class="col-4 py-2"><img src="./images/models.png" alt="Models Category" /></div>
                <div class="col-8 py-2 px-0">
                  <span class="text-uppercase d-block">Models</span>
                  <span class="d-block cat-num">(8)</span>
                </div>
              </div>
            </div>

            <div class="col-6 col-lg-3 mb-2 px-0">
              <div class="row mx-1 shadow-sm ">
                <div class="col-4 py-2"><img src="./images/presenter.png" alt="Presenters Category" /></div>
                <div class="col-8 py-2 px-0">
                  <span class="text-uppercase d-block">Presenters</span>
                  <span class="d-block cat-num">(8)</span>
                </div>
              </div>
            </div>

            <div class="col-6 col-lg-3 mb-2 px-0">
              <div class="row mx-1 shadow-sm ">
                <div class="col-4 py-2"><img src="./images/hair.png" alt="Hair, MUAs, Designers Category" /></div>
                <div class="col-8 py-2 px-0">
                  <span class="text-uppercase d-block">Hair, MUAs, Designers</span>
                  <span class="d-block cat-num">(8)</span>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="searchFilters mt-2">
          <div class="p-3 d-block d-md-none">
            <span class="d-block d-md-none float-left">Advance Filter</span>
            <button class="btn btn-primary btn-sm d-block d-md-none float-right" type="button" data-toggle="collapse"
              data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
              <i class="fas fa-filter"></i>
            </button>
            <div class="clear"></div>
          </div>

          <div class="searchparam shadow-sm collapse dont-collapse-sm show" id="collapseExample">
            <div class=" row well px-3">
              <!-- Collapse Panel -->
              <div class="col-12 col-sm-6 col-md-3 py-3">
                <select placeholder="Select Location" class="form-control">
                  <option>Delhi</option>
                </select>
              </div>
              <div class="col-12 col-sm-6 col-md-2 py-3"> <select placeholder="Select Location" class="form-control">
                  <option>Delhi</option>
                </select></div>
              <div class="col-12 col-sm-6 col-md-2 py-3">
                <select placeholder="Select Location" class="form-control">
                  <option>Delhi</option>
                </select>
              </div>
              <div class="col-12 col-sm-6 col-md-2 py-3">
                <select placeholder="Select Location" class="form-control">
                  <option>Delhi</option>
                </select>
              </div>
              <div class="col-12 col-sm-6 col-md-2 py-3">
                <input type="text" class="form-control">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="searchResults my-3">
    <div class="container noResults shadow-sm">
      <div class="col-sm-12 row mx-auto p-4">
        <div class="col-12 col-sm-6 text-right"><img src="./images/noProfilesFound.jpg" alt="No profile found" /></div>
        <div class="col-12 col-sm-6">
          <h4>No Profiles found from Pondicherry</h4>
          <h6>Explore other locations nearby for your requirements</h6>
          <h6 class="pt-2">If you want to showcase your talent from this location</h6>
          <button class="btn btn-lg btn-primary">Join Now</button>
        </div>
      </div>
    </div>

    <div class="container resultlisting my-4">
      <div class="row">
        <div class="col-6 px-0">Showcasing India’s Talent Nationwide</div>
        <div class="col-6 px-0 text-right">15 Results</div>
      </div>
      <div class="row py-3">
        <a href="#" class="col-sm-2">
          <div class="card h-100">
            <img class="card-img-top" src="./images/profiles/1.jpg" alt="Card image cap">
            <div class="card-body">
              <h5 class="card-title">Aditi Rawat</h5>
              <p class="card-text"><i class="fas fa-map-marker-alt"></i> Delhi. India</p>
              <p><span class="badge c-actors">Actor</span><span class="badge c-models">Model</span><span
                  class="badge c-photographers">Photographer</span><span class="badge c-musicians">Musician</span><span class="badge c-more">+2</span></p>
            </div>
          </div>
        </a>

        <a href="#" class="col-sm-2">
          <div class="card h-100">
            <img class="card-img-top" src="./images/profiles/2.jpg" alt="Card image cap">
            <div class="card-body">
              <h5 class="card-title">Anushka Singh</h5>
              <p class="card-text"><i class="fas fa-map-marker-alt"></i> Maharashtra. India</p>
              <p><span class="badge c-influencers">Influencer</span><span class="badge c-models">Model</span></p>
            </div>
          </div>
        </a>

        <a href="#" class="col-sm-2">
          <div class="card h-100">
            <img class="card-img-top" src="./images/profiles/3.jpg" alt="Card image cap">
            <div class="card-body">
              <h5 class="card-title">Adiyta Rawat</h5>
              <p class="card-text"><i class="fas fa-map-marker-alt"></i> Delhi. India</p>
              <p><span class="badge c-actors">Actor</span><span class="badge c-models">Model</span><span
                  class="badge c-photographers">Photographer</span><span class="badge c-musicians">Musician</span></p>
            </div>
          </div>
        </a>

        <a href="#" class="col-sm-2">
          <div class="card h-100">
            <img class="card-img-top" src="./images/profiles/1.jpg" alt="Card image cap">
            <div class="card-body">
              <h5 class="card-title">Adiyta Rawat</h5>
              <p class="card-text"><i class="fas fa-map-marker-alt"></i> Delhi. India</p>
              <p><span class="badge c-actors">Actor</span><span class="badge c-models">Model</span><span
                  class="badge c-photographers">Photographer</span><span class="badge c-musicians">Musician</span></p>
            </div>
          </div>
        </a>

        <a href="#" class="col-sm-2">
          <div class="card h-100">
            <img class="card-img-top" src="./images/profiles/1.jpg" alt="Card image cap">
            <div class="card-body">
              <h5 class="card-title">Adiyta Rawat</h5>
              <p class="card-text"><i class="fas fa-map-marker-alt"></i> Delhi. India</p>
              <p><span class="badge c-actors">Actor</span><span class="badge c-models">Model</span><span
                  class="badge c-photographers">Photographer</span><span class="badge c-musicians">Musician</span></p>
            </div>
          </div>
        </a>

        <a href="#" class=" col-sm-2">
          <div class="card h-100">
            <img class="card-img-top" src="./images/profiles/1.jpg" alt="Card image cap">
            <div class="card-body">
              <h5 class="card-title">Adiyta Rawat</h5>
              <p class="card-text"><i class="fas fa-map-marker-alt"></i> Delhi. India</p>
              <p><span class="badge c-actors">Actor</span><span class="badge c-models">Model</span><span
                  class="badge c-photographers">Photographer</span><span class="badge c-musicians">Musician</span></p>
            </div>
          </div>
        </a>

        <a href="#" class="col-sm-2">
          <div class="card h-100">
            <img class="card-img-top" src="./images/profiles/1.jpg" alt="Card image cap">
            <div class="card-body">
              <h5 class="card-title">Adiyta Rawat</h5>
              <p class="card-text"><i class="fas fa-map-marker-alt"></i> Delhi. India</p>
              <p><span class="badge c-actors">Actor</span><span class="badge c-models">Model</span><span
                  class="badge c-photographers">Photographer</span><span class="badge c-musicians">Musician</span></p>
            </div>
          </div>
        </a>

        <a href="#" class="col-sm-2">
          <div class="card h-100">
            <img class="card-img-top" src="./images/profiles/1.jpg" alt="Card image cap">
            <div class="card-body">
              <h5 class="card-title">Adiyta Rawat</h5>
              <p class="card-text"><i class="fas fa-map-marker-alt"></i> Delhi. India</p>
              <p><span class="badge c-actors">Actor</span><span class="badge c-models">Model</span><span
                  class="badge c-photographers">Photographer</span><span class="badge c-musicians">Musician</span></p>
            </div>
          </div>
        </a>

        <a href="#" class="col-sm-2">
          <div class="card h-100">
            <img class="card-img-top" src="./images/profiles/1.jpg" alt="Card image cap">
            <div class="card-body">
              <h5 class="card-title">Adiyta Rawat</h5>
              <p class="card-text"><i class="fas fa-map-marker-alt"></i> Delhi. India</p>
              <p><span class="badge c-actors">Actor</span><span class="badge c-models">Model</span><span
                  class="badge c-photographers">Photographer</span><span class="badge c-musicians">Musician</span></p>
            </div>
          </div>
        </a>

        <a href="#" class="col-sm-2">
          <div class="card h-100">
            <img class="card-img-top" src="./images/profiles/1.jpg" alt="Card image cap">
            <div class="card-body">
              <h5 class="card-title">Adiyta Rawat</h5>
              <p class="card-text"><i class="fas fa-map-marker-alt"></i> Delhi. India</p>
              <p><span class="badge c-actors">Actor</span><span class="badge c-models">Model</span><span
                  class="badge c-photographers">Photographer</span><span class="badge c-musicians">Musician</span></p>
            </div>
          </div>
        </a>

        <a href="#" class="col-sm-2">
          <div class="card h-100">
            <img class="card-img-top" src="./images/profiles/1.jpg" alt="Card image cap">
            <div class="card-body">
              <h5 class="card-title">Adiyta Rawat</h5>
              <p class="card-text"><i class="fas fa-map-marker-alt"></i> Delhi. India</p>
              <p><span class="badge c-actors">Actor</span><span class="badge c-models">Model</span><span
                  class="badge c-photographers">Photographer</span><span class="badge c-musicians">Musician</span></p>
            </div>
          </div>
        </a>

        <a href="#" class=" col-sm-2">
          <div class="card h-100">
            <img class="card-img-top" src="./images/profiles/1.jpg" alt="Card image cap">
            <div class="card-body">
              <h5 class="card-title">Adiyta Rawat</h5>
              <p class="card-text"><i class="fas fa-map-marker-alt"></i> Delhi. India</p>
              <p><span class="badge c-actors">Actor</span><span class="badge c-models">Model</span><span
                  class="badge c-photographers">Photographer</span><span class="badge c-musicians">Musician</span></p>
            </div>
          </div>
        </a>

      </div>
    </div>
  </section>
<?php get_footer(); ?>