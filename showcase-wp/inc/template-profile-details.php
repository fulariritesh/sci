<?php
/* Template Name: Profile details Page */

if ($_SERVER["REQUEST_METHOD"] == "POST") {

}

get_header();

?>

    <!-- Pagination -->
    <ul class="nav jp-nav justify-content-center">
      <li class="nav-item">
        <a class="nav-link" href="welcome-msg.html">Get Started</a>
      </li>
      <li class="nav-item act">
        <a class="nav-link" href="profile-details.html">Details</a>
      </li>
      <li class="nav-item">
        <a class="nav-link d-none d-sm-block" href="physical-attributes.html">Physical Attributes</a>
        <a class="nav-link d-block d-sm-none"> Attributes</a>
      </li>
      <li class="nav-item">
        <a class="nav-link d-none d-sm-block" href="#">Add a headshot</a>
        <a class="nav-link d-block d-sm-none">Headshot</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Complete</a>
      </li>
    </ul>
    <section class="pr-details d-flex justify-content-center py-5">
      <div class="card col-11 col-md-8 col-lg-7 col-xl-4 shadow-sm p-0">
        <div class="card-header">Enter your details</div>
        <div class="card-body px-4">
          <form action="">
            <div class="form-row">
              <div class="col-md-6 mb-3">
                <label for="FirstName"
                  >First name<span class="float-right text-danger pl-1"
                    >*</span
                  ></label
                >
                <input
                  type="text"
                  class="form-control"
                  id="FirstName"
                  required
                />
                <div class="valid-feedback">Looks good!</div>
                <div class="invalid-feedback">error msg</div>
              </div>
              <div class="col-md-6 mb-3">
                <label for="LastName"
                  >Last name<span class="float-right text-danger pl-1"
                    >*</span
                  ></label
                >
                <input
                  type="text"
                  class="form-control"
                  id="LastName"
                  required
                />
                <div class="valid-feedback">Looks good!</div>
                <div class="invalid-feedback">error msg</div>
              </div>
            </div>
            <div class="form-group">
              <label for="DOB"
                >Birth Date<span class="float-right text-danger pl-1"
                  >*</span
                ></label
              >
              <input type="date" class="form-control" id="DOB" required />
              <div class="valid-feedback">Looks good!</div>
                <div class="invalid-feedback">error msg</div>
            </div>
            <div class="form-group">
              <div>
                <label for="Gender"
                  >Gender<span class="float-right text-danger pl-1"
                    >*</span
                  ></label
                >
              </div>
              <div class="btn-group btn-group-toggle" data-toggle="buttons">
                <label class="btn btn-details-gend">
                  <input type="radio" name="options" id="option1" checked />
                  Male
                </label>
                <label class="btn btn-details-gend">
                  <input type="radio" name="options" id="option2" />Female</label>
                <label class="btn btn-details-gend">
                  <input type="radio" name="options" id="option3" checked />Prefer not to say</label>
                <label class="btn btn-details-gend">
                  <input type="radio" name="options" id="option3" />Custom</label>
              </div>
              <input type="text" class="form-control mt-3" />
            </div>
            <div class="form-group">
              <label for="Mobile"
                >Mobile<span class="float-right text-danger pl-1"
                  >*</span
                ></label
              >
              <input type="text" class="form-control" required />
              <div class="valid-feedback">Looks good!</div>
                <div class="invalid-feedback">error msg</div>
            </div>
            <div class="form-group">
              <label for="Location"
                >Location<span class="float-right text-danger pl-1"
                  >*</span
                ></label
              >
              <select class="form-control" id="">
                <option>1</option>
                <option>2</option>
                <option>3</option>
                <option>4</option>
                <option>5</option>
              </select>
            </div>
            <button type="" class="btn btn-lg btn-details-bck px-5">Back</button>
            <button type="submit" class="btn btn-lg btn-details-nxt float-right px-5">Next</button>
          </form>
        </div>
      </div>
    </section>


<?php
get_sidebar();
get_footer();
?>
