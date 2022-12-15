<body class="font-poppins">

    <div class="w-full min-h-screen bg-blue-50 p-6">

        <!--<h1 class="font-bold text-xl text-center md:text-3xl md:mt-12 mb-4">Check out the <span class="text-red-500">Features</span> of our App</h1>-->

        <!-- Card Container Start -->

        <div class="flex flex-wrap justify-center">

            <div class="flex flex-col bg-white rounded-lg shadow-md w-full m-6 overflow-hidden sm:w-52">

                <img src="{{asset('storage/logo/web.png')}}" alt="" class="object-scale-down h-40 w-96 rounded-md mb-2">

                <h2 class="text-center px-2 pb-5">Sitio Web</h2>  
                
                <a href="{{ route('home') }}" class="bg-blue-500 text-white p-3 text-center hover:bg-blue-800 transition-all duration-500">Ir</a>

            </div>



            <div class="flex flex-col bg-white rounded-lg shadow-md w-full m-6 overflow-hidden sm:w-52">

                <img src="{{asset('storage/logo/category.png')}}" alt="" class="object-scale-down h-40 w-96 rounded-md mb-2">

                <h2 class="text-center px-2 pb-5">Categoria</h2>  
                
                <a href="{{ route('show-category') }}" class="bg-blue-500 text-white p-3 text-center hover:bg-blue-800 transition-all duration-500">Ir</a>

            </div>



            <div class="flex flex-col bg-white rounded-lg shadow-md w-full m-6 overflow-hidden sm:w-52">

                <img src="{{asset('storage/logo/online-learning.png')}}" alt="" class="object-scale-down h-40 w-96 rounded-md mb-2">

                <h2 class="text-center px-2 pb-5">Cursos</h2>  
                
                <a href="{{ route('show-course') }}" class="bg-blue-500 text-white p-3 text-center hover:bg-blue-800 transition-all duration-500">Ir</a>

            </div>



            <div class="flex flex-col bg-white rounded-lg shadow-md w-full m-6 overflow-hidden sm:w-52">

                <img src="{{asset('storage/logo/edit.png')}}" alt="" class="object-scale-down h-40 w-96 rounded-md mb-2">

                <h2 class="text-center px-2 pb-5">Post</h2>  
                
                <a href="{{ route('show-post') }}" class="bg-blue-500 text-white p-3 text-center hover:bg-blue-800 transition-all duration-500">Ir</a>

            </div>

        </div>

    </div>

</body>
