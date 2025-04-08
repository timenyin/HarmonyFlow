<?php

session_start();

function ErrorMessage()
{
    if (isset($_SESSION["ErrorMessage"])) {
        $Output = "<div class=\"toast-container position-fixed top-0 end-0 p-3\" style=\"z-index: 1100;\">";
        $Output .= "<div id=\"errorToast\" class=\"toast align-items-center text-white bg-danger border-0\" role=\"alert\" aria-live=\"assertive\" aria-atomic=\"true\">";
        $Output .= "<div class=\"d-flex\">";
        $Output .= "<div class=\"toast-body\">";
        $Output .= "<i class=\"fa-solid fa-circle-exclamation me-2\"></i>" . htmlentities($_SESSION["ErrorMessage"]);
        $Output .= "</div>";
        $Output .= "<button type=\"button\" class=\"btn-close btn-close-white me-2 m-auto\" data-bs-dismiss=\"toast\" aria-label=\"Close\"></button>";
        $Output .= "</div></div></div>";
        $Output .= "<script>
                        document.addEventListener('DOMContentLoaded', function() {
                            var errorToast = document.getElementById('errorToast');
                            if (errorToast) {
                                var toast = new bootstrap.Toast(errorToast, {
                                    autohide: true,
                                    delay: 5000
                                });
                                toast.show();
                            }
                        });
                    </script>";
        $_SESSION["ErrorMessage"] = null;
        return $Output;
    }
}

function SuccessMessage()
{
    if (isset($_SESSION["SuccessMessage"])) {
        $Output = "<div class=\"toast-container position-fixed top-0 end-0 p-3\" style=\"z-index: 1100;\">";
        $Output .= "<div id=\"successToast\" class=\"toast align-items-center text-white bg-success border-0\" role=\"alert\" aria-live=\"assertive\" aria-atomic=\"true\">";
        $Output .= "<div class=\"d-flex\">";
        $Output .= "<div class=\"toast-body\">";
        $Output .= "<i class=\"fa-solid fa-circle-check me-2\"></i>" . htmlentities($_SESSION["SuccessMessage"]);
        $Output .= "</div>";
        $Output .= "<button type=\"button\" class=\"btn-close btn-close-white me-2 m-auto\" data-bs-dismiss=\"toast\" aria-label=\"Close\"></button>";
        $Output .= "</div></div></div>";
        $Output .= "<script>
                        document.addEventListener('DOMContentLoaded', function() {
                            var successToast = document.getElementById('successToast');
                            if (successToast) {
                                var toast = new bootstrap.Toast(successToast, {
                                    autohide: true,
                                    delay: 5000
                                });
                                toast.show();
                            }
                        });
                    </script>";
        $_SESSION["SuccessMessage"] = null;
        return $Output;
    }
}

function ErrorBlogMessage()
{
    if (isset($_SESSION["ErrorBlogMessage"])) {
        $Output = "<div id=\"sessionMessage\" class=\"alert alert-light alert-dismissible fade show position-fixed bottom-0 border border-danger start-50 translate-middle-x z-index-99 z-index-999 d-lg-flex justify-content-between align-items-center shadow p-4 col-9 col-md-5\" role=\"alert\" style=\"transition: opacity 0.5s ease-in-out;\">";
        $Output .= "<div class=\"d-flex align-items-center\">";
        $Output .= "<i class=\"bi bi-emoji-tear-fill\" style=\"font-size: 3rem; color: rgb(224 113 15) !important; margin-right: 1rem;\"></i>";
        $Output .= "<div>";
        $Output .= "<p class=\"m-0 pe-3 text-danger\">" . htmlentities($_SESSION["ErrorBlogMessage"]) . "</p>";
        $Output .= "<small>We will also get back to you on your reply.</small>";
        $Output .= "</div>";
        $Output .= "</div>";
        $Output .= "<button type=\"button\" class=\"btn btn-link text-primary-hover mb-0 position-absolute end-0 top-0\" data-bs-dismiss=\"alert\" aria-label=\"Close\"><i class=\"bi bi-x-lg\"></i></button>";
        $Output .= "</div>";
        $_SESSION["ErrorBlogMessage"] = null; // Clear session message after rendering

        return $Output;
    }
    return "";
}

function ShowSuccessMessage()
{
    if (isset($_SESSION["ShowSuccessMessage"])) {
        $Output = "<div id=\"sessionMessage\" class=\"alert alert-light alert-dismissible fade show position-fixed bottom-0 start-50 translate-middle-x z-index-99 z-index-999 d-lg-flex justify-content-between align-items-center shadow p-4 col-9 col-md-5\" role=\"alert\" style=\"transition: opacity 0.5s ease-in-out;\">";
        $Output .= "<div class=\"d-flex align-items-center\">";
        $Output .= "<div>";
        $Output .= "<p class=\"m-0 pe-3 text-success\">" . htmlentities($_SESSION["ShowSuccessMessage"]) . "</p>";
        $Output .= "<small>We will also get back to you on your reply.</small>";
        $Output .= "</div>";
        $Output .= "<img src=\"assets/images/icon/emoji_happyFace.svg\" alt=\"emoji LogoImage\" class=\"img-fluid ms-3\" style=\"width: 50px; height:auto;\">";
        $Output .= "</div>";
        $Output .= "<button type=\"button\" class=\"btn btn-link text-primary-hover mb-0 position-absolute end-0 top-0\" data-bs-dismiss=\"alert\" aria-label=\"Close\"><i class=\"bi bi-x-lg\"></i></button>";
        $Output .= "</div>";
        $_SESSION["ShowSuccessMessage"] = null; // Clear session message after rendering

        return $Output;
    }
    return "";
}
