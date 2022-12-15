<div class="bg-white shadow-lg rounded-lg px-4 py-6 text-center object-contain">
    <a href="{{ route('course',$course->slug) }}">
        <img src="{{ asset($course->image) }}" alt="" class="object-scale-down h-48 w-96 rounded-md mb-2">
        <h2 class="text-lg text-gray-600 truncate uppercase">{{ $course->name }} </h2>
        <h3 class="text-md text-gray-500">{{ $course->excerpt }} </h3>
   <!--<img src="{s{ asset($course->profile_photo_url) }}" class="rounded-full mx-auto h-16 w-16">-->
    </a>
</div>
