<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>
  <title>5200411441</title>
</head>
<body class="flex flex-col min-h-screen bg-gray-100">

  @if ($errors->any())
    <div id="notificationBackground" class="fixed inset-0 bg-gray-900 opacity-50"></div>
    <div id="notification" class="fixed inset-0 flex items-center justify-center z-50">
      <div class="w-64 bg-white rounded shadow">
        <div class="flex justify-between items-center px-4 py-2 border-b">
          <h2 class="text-lg font-semibold text-indigo-600">Notifications</h2>
          <button id="notificationCloseButton" type="button" class="text-gray-500 hover:text-gray-700 focus:outline-none">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6">
              <line x1="18" y1="6" x2="6" y2="18"></line>
              <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
          </button>
        </div>
        @foreach ($errors->all() as $error)
        <div class="p-4">
          {{ $error }}
        </div>
        @endforeach
      </div>
    </div>
    <script>
      $(document).ready(function() {
        $("#notificationCloseButton").click(function() {
          $("#notification").addClass("hidden");
          $("#notificationBackground").addClass("hidden");
        });
      });
    </script>
  @endif

  <main class="flex-grow">
    <div class="container mx-auto w-3/5">
      <h1 class="text-5xl pt-20 font-bold text-indigo-600">AES-256-CBC</h1>
      <div class="grid grid-cols-11 gap-3 py-5">
        <div class="col-span-5">
          <div class="inline-flex items-center">
            <h2 class="text-2xl font-medium pr-2">File Encryption</h2>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
              <path fill-rule="evenodd" d="M12 1.5a5.25 5.25 0 00-5.25 5.25v3a3 3 0 00-3 3v6.75a3 3 0 003 3h10.5a3 3 0 003-3v-6.75a3 3 0 00-3-3v-3c0-2.9-2.35-5.25-5.25-5.25zm3.75 8.25v-3a3.75 3.75 0 10-7.5 0v3h7.5z" clip-rule="evenodd" />
            </svg>
          </div>
          <form class="text-xl pt-3" action="{{route('encrypt.store')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="mt-3">
              <label for="fileUploadOriginal" class="block leading-6 text-gray-900">Original File</label>
              <input type="file" name="fileUploadOriginal" id="fileUploadOriginal" class="mt-1 p-2.5 block w-full rounded-md border-0 py-1.5 shadow-sm bg-white ring-1 ring-inset ring-gray-300 sm:text-sm sm:leading-6 file:mr-5 file:py-2 file:px-6 file:rounded-full file:border-0 file:text-sm file:font-medium file:bg-indigo-600 file:text-white hover:file:cursor-pointer hover:file:bg-indigo-500" required>
            </div>
            <div class="mt-3">
                <label for="initVectorEncrypt" class="block leading-6 text-gray-900">Initialization Vector</label>
                <input type="text" name="initVectorEncrypt" id="initVectorEncrypt" class="mt-1 p-2.5 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-gray-600 sm:text-sm sm:leading-6" placeholder="Must be 16 characters" required>
            </div>
            <div class="mt-3">
                <label for="secretKeyEncrypt" class="block leading-6 text-gray-900">Secret Key</label>
                <input type="text" name="secretKeyEncrypt" id="secretKeyEncrypt" class="mt-1 p-2.5 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-gray-600 sm:text-sm sm:leading-6" placeholder="Any characters" required>
            </div>
            <p class="text-sm pt-2">Once you click the encrypt button below, the encrypted image should be downloaded to your personal computer automatically.</p>
            <div class="mt-5 text-center">
                <button name="encrypt" type="submit" class="inline-flex justify-center rounded-md bg-indigo-600 py-2 px-3 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">Encrypt</button>
            </div>
          </form><br>
        </div>
  
        <div class="col-span-1 block my-32 flex flex-col items-center justify-center">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
            <path fill-rule="evenodd" d="M16.72 7.72a.75.75 0 011.06 0l3.75 3.75a.75.75 0 010 1.06l-3.75 3.75a.75.75 0 11-1.06-1.06l2.47-2.47H3a.75.75 0 010-1.5h16.19l-2.47-2.47a.75.75 0 010-1.06z" clip-rule="evenodd" />
          </svg>
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
            <path fill-rule="evenodd" d="M7.28 7.72a.75.75 0 010 1.06l-2.47 2.47H21a.75.75 0 010 1.5H4.81l2.47 2.47a.75.75 0 11-1.06 1.06l-3.75-3.75a.75.75 0 010-1.06l3.75-3.75a.75.75 0 011.06 0z" clip-rule="evenodd" />
          </svg>
        </div>
  
        <div class="col-span-5">
          <div class="inline-flex items-center">
            <h2 class="text-2xl font-medium pr-2">File Decryption</h2>  
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
              <path d="M18 1.5c2.9 0 5.25 2.35 5.25 5.25v3.75a.75.75 0 01-1.5 0V6.75a3.75 3.75 0 10-7.5 0v3a3 3 0 013 3v6.75a3 3 0 01-3 3H3.75a3 3 0 01-3-3v-6.75a3 3 0 013-3h9v-3c0-2.9 2.35-5.25 5.25-5.25z" />
            </svg>
          </div>
          <form class="text-xl pt-3" action="{{route('decrypt.store')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="mt-3">
              <label for="fileUploadDecrypt" class="block leading-6 text-gray-900">Encrypted File</label>
              <input type="file" name="fileUploadDecrypt" id="fileUploadDecrypt" class="mt-1 p-2.5 block w-full rounded-md border-0 py-1.5 shadow-sm bg-white ring-1 ring-inset ring-gray-300 sm:text-sm sm:leading-6 file:mr-5 file:py-2 file:px-6 file:rounded-full file:border-0 file:text-sm file:font-medium file:bg-indigo-600 file:text-white hover:file:cursor-pointer hover:file:bg-indigo-500" required>
            </div>
            <div class="mt-3">
              <label for="initVectorDecrypt" class="block leading-6 text-gray-900">Initialization Vector</label>
              <input type="text" name="initVectorDecrypt" id="initVectorDecrypt" class="mt-1 p-2.5 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-gray-600 sm:text-sm sm:leading-6" placeholder="Must be 16 characters" required>
            </div>
            <div class="mt-3">
              <label for="secretKeyDecrypt" class="block leading-6 text-gray-900">Secret Key</label>
              <input type="text" name="secretKeyDecrypt" id="secretKeyDecrypt" class="mt-1 p-2.5 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-gray-600 sm:text-sm sm:leading-6" placeholder="Any characters" required>
            </div>
            <p class="text-sm pt-2">Once you click the decrypt button below, the decrypted image should be downloaded to your personal computer automatically.</p>
            <div class="mt-5 text-center">
              <button name="decrypt" type="submit" class="inline-flex justify-center rounded-md bg-indigo-600 py-2 px-3 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">Decrypt</button>
            </div>
          </form><br>
        </div>
      </div>
  </main>

  <footer class="bg-gray-900 py-4">
    <div class="container mx-auto w-3/5">
      <div class="flex items-center justify-between">
        <div class="text-gray-500 text-sm">
          © Ahlul Aziz A.P
        </div>
      </div>
    </div>
  </footer>
  
</body>
</html>