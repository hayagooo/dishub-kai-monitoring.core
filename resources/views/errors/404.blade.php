<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Halaman Tidak Tersedia - SIMPKA</title>
    <link rel="shortcut icon" href="{{ asset('images/logo.png') }}" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp"></script>
</head>
<body>
    <div class="flex items-center justify-center w-screen h-screen bg-gradient-to-r from-purple-600 to-purple-400">
  <div class="px-40 py-20 bg-white rounded-md shadow-xl">
    <div class="flex flex-col items-center">
      <h1 class="font-bold text-blue-600 text-9xl">
          <img src="{{ asset('images/not_found.png') }}" width="260px" alt="not_found">
      </h1>

      <h6 class="mb-2 text-2xl font-bold text-center text-gray-800 md:text-3xl">
        <span class="text-purple-500">Oops!</span> Halaman tidak tersedia
      </h6>

      <p class="mb-8 text-center text-gray-500 md:text-lg">
        Halaman yang kamu tuju tidak tersedia.
      </p>

      <a
        href="/"
        class="px-6 py-3 rounded-lg text-sm font-semibold text-purple-800 bg-purple-100"
        >Kembali</a
      >
    </div>
  </div>
</div>
</body>
</html>
