<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> <?= $data['page_title'] ?> </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="icon" type="image/png" href="./assets/images/favicon.webp">
     <!-- Bootstrap Font Icon CSS -->
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

  </head>
  <style>
    .input-group {
        width: 100%;
        display: flex;
        align-items: center;
        border-top: 1px solid #ced4da;
        padding: 10px;
    }

    .input-group form {
        display: flex;
        width: 100%;
    }

    #commentInput {
        width: 80%;
        padding: 10px;
        border-radius: 0.25rem 0 0 0.25rem;
        border: 1px solid #ced4da;
        border-right: none; /* Remove right border to connect with the button */
    }

    #addCommentBtn {
        width: 20%;
        background-color: #007bff;
        color: white;
        border: 1px solid #007bff;
        border-radius: 0 0.25rem 0.25rem 0;
        padding: 10px;
    }

    /* Optional: Add hover effects for better UI */
    #addCommentBtn:hover {
        background-color: #0056b3;
        border-color: #0056b3;
    }
</style>

<body class="bg-dark">
