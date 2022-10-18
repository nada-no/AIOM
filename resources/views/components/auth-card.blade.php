<style>
.card-bg {
  background-color: #8EB8E5;
  color:rgb(73, 73, 73);
}
input[type="text"], input[type="email"], input[type="password"]{
    width:80%;
    margin: auto;
}
label {
    margin-left: 10%;
    margin-top: 5%;
    margin-bottom:4%;
}
.bg-dark {
    background-color: #2E282A;
    color:white;
}
</style>
<div class="bg-dark min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
    <div>
        {{ $logo }}
    </div>

    <div class="w-full sm:max-w-md mt-6 px-6 py-4 card-bg shadow-md overflow-hidden sm:rounded-lg">
        {{ $slot }}
    </div>
</div>
