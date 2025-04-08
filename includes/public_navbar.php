<nav class="navbar navbar-expand-lg container-small px-3 px-lg-7 px-xxl-3"><a class="navbar-brand flex-1 flex-lg-grow-0"
        href="index.php">
        <div class="d-flex align-items-center"><img src="assets/img/icons/logo.png" alt="phoenix" width="40" />
            <h5 class="logo-text fw-bold ms-2">NexusFlow</h5>
        </div>
    </a>
    <!-- small screen navbar-->
    <div class="d-lg-none">
        <div class="theme-control-toggle fa-icon-wait px-2"><input
                class="form-check-input ms-0 theme-control-toggle-input" type="checkbox"
                data-theme-control="phoenixTheme" value="dark" id="themeControlToggleSm" /><label
                class="mb-0 theme-control-toggle-label theme-control-toggle-light" for="themeControlToggleSm"
                data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="Switch theme"
                style="height:32px;width:32px;"><span class="icon" data-feather="moon">
                </span>
            </label>
            <label class="mb-0 theme-control-toggle-label theme-control-toggle-dark" for="themeControlToggleSm"
                data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="Switch theme"
                style="height:32px;width:32px;">
                <span class="icon" data-feather="sun"></span>
            </label>
        </div>
    </div>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <div class="border-bottom border-translucent border-bottom-lg-0 mb-2">
            <div class="search-box d-inline d-lg-none">
                <form class="position-relative"><input class="form-control search-input search rounded-pill my-4"
                        type="search" placeholder="Search" aria-label="Search" />
                    <span class="fas fa-search search-box-icon"></span>
                </form>
            </div>
        </div>
        <!-- End of small screen navbar   -->


        <!-- Regular menu/ Dropdown  -->
        <ul class="navbar-nav travel-nav-top me-auto" data-dropdown-on-hover="data-dropdown-on-hover">
            <!-- Mega DropDown Menu -->
            <div class="dropdown">
                <button
                    class="btn text-primary ps-0 pe-5 text-nowrap dropdown-toggle dropdown-caret-none fs-8 fw-bold nav-link"
                    data-category-btn="data-category-btn" data-bs-toggle="dropdown">
                    <span class="ms-2"></span>
                    Category
                    <span class="fa-solid fa-angle-down ms-1"></span>
                </button>
                <div class="dropdown-menu border border-translucent py-0 category-dropdown-menu">
                    <div class="card border-0 scrollbar" style="max-height: 657px;">
                        <div class="card-body p-6 pb-3">
                            <div class="row gx-7 gy-5 mb-5">
                                <div class="col-12 col-sm-6 col-md-4">
                                    <div class="d-flex align-items-center mb-3"><span class="text-primary me-2"
                                            data-feather="pocket" style="stroke-width:3;"></span>
                                        <h6 class="text-body-highlight mb-0 text-nowrap">Our Product</h6>
                                    </div>
                                    <div class="ms-n2"><a
                                            class="text-body-emphasis d-block mb-1 text-decoration-none bg-body-highlight-hover px-2 py-1 rounded-2"
                                            href="#!">Task Management</a><a
                                            class="text-body-emphasis d-block mb-1 text-decoration-none bg-body-highlight-hover px-2 py-1 rounded-2"
                                            href="#!">AI Tools</a>
                                        <a class="text-body-emphasis d-block mb-1 text-decoration-none bg-body-highlight-hover px-2 py-1 rounded-2"
                                            href="#!">Reports </a>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6 col-md-4">
                                    <div class="d-flex align-items-center mb-3"><span class="text-primary me-2"
                                            data-feather="grid" style="stroke-width:3;"></span>
                                        <h6 class="text-body-highlight mb-0 text-nowrap">Resources
                                        </h6>
                                    </div>
                                    <div class="ms-n2"><a
                                            class="text-body-emphasis d-block mb-1 text-decoration-none bg-body-highlight-hover px-2 py-1 rounded-2"
                                            href="#!">Blog</a>
                                        <a class="text-body-emphasis d-block mb-1 text-decoration-none bg-body-highlight-hover px-2 py-1 rounded-2"
                                            href="#!">Tutorials</a>
                                        <a class="text-body-emphasis d-block mb-1 text-decoration-none bg-body-highlight-hover px-2 py-1 rounded-2"
                                            href="#!">Documentation </a>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6 col-md-4">
                                    <div class="d-flex align-items-center mb-3">
                                        <span class="text-primary me-2" data-feather="codesandbox"
                                            style="stroke-width:3;">
                                        </span>
                                        <h6 class="text-body-highlight mb-0 text-nowrap">Solutions</h6>
                                    </div>
                                    <div class="ms-n2"><a
                                            class="text-body-emphasis d-block mb-1 text-decoration-none bg-body-highlight-hover px-2 py-1 rounded-2"
                                            href="#!">For Tech Teams</a>
                                        <a class="text-body-emphasis d-block mb-1 text-decoration-none bg-body-highlight-hover px-2 py-1 rounded-2"
                                            href="#!"> For Universities</a>
                                        <a class="text-body-emphasis d-block mb-1 text-decoration-none bg-body-highlight-hover px-2 py-1 rounded-2"
                                            href="#!"> For Government </a>
                                        <a class="text-body-emphasis d-block mb-1 text-decoration-none bg-body-highlight-hover px-2 py-1 rounded-2"
                                            href="#!">Individual Use</a>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End of Mega DropDown Menu -->

            <li class="nav-item dropdown"><a class="nav-link fs-8 fw-bold  " href="#!" role="button"
                    data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-haspopup="true"
                    aria-expanded="false">Features</a>
            </li>
            <li class="nav-item dropdown"><a class="nav-link fs-8 fw-bold  " href="#!" role="button"
                    data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-haspopup="true"
                    aria-expanded="false">Use Cases</a>
            </li>

            <li class="nav-item dropdown"><a class="nav-link fs-8 fw-bold  " href="#!" role="button"
                    data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-haspopup="true"
                    aria-expanded="false">Pricing</a>
            </li>
        </ul>
        <!-- End of Regular menu/ Dropdown  -->


        <!-- Light Mode -->
        <div class="d-grid d-lg-flex align-items-center">
            <div class="nav-item d-flex align-items-center d-none d-lg-block pe-2">
                <div class="theme-control-toggle fa-icon-wait px-2"><input
                        class="form-check-input ms-0 theme-control-toggle-input" type="checkbox"
                        data-theme-control="phoenixTheme" value="dark" id="themeControlToggle" /><label
                        class="mb-0 theme-control-toggle-label theme-control-toggle-light" for="themeControlToggle"
                        data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="Switch theme"
                        style="height:32px;width:32px;"><span class="icon" data-feather="moon"></span></label><label
                        class="mb-0 theme-control-toggle-label theme-control-toggle-dark" for="themeControlToggle"
                        data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="Switch theme"
                        style="height:32px;width:32px;"><span class="icon" data-feather="sun"></span></label></div>
            </div>

            <!-- Sign in -->
            <a class="btn btn-link text-body order-1 order-lg-0 ps-4 me-lg-2 fs-8" href="sign-in.php">Sign in</a>
            <!-- Sign up -->
            <a class="btn btn-phoenix-primary order-0 fs-8 animated-border-button" href="sign-up.php">
                <span class="fw-bold">Try Now <i class="fa-solid fa-arrow-right mx-1"></i> </span>
            </a>
        </div>
        <!-- <li class="nav-item">
            <a class="nav-link" href="settings/security.php">
                <i class="bi bi-shield-lock me-2"></i>Security
            </a>
        </li> -->
    </div>
</nav>