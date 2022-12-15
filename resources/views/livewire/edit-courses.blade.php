<div>
    <a wire:click="$set('open', true)"
        class="font-bold text-white py-2 px-4 rounded cursor-pointer bg-green-600 hover:bg-green-500">
        Editar <i class="fas fa-edit"></i>
    </a>

    <x-jet-dialog-modal wire:model="open">
        <x-slot name="title">
            Editar el Curso
        </x-slot>

        <x-slot name="content">

            <div class="mb-4">
                <x-jet-label value="Nombre" />
                <x-jet-input wire:model="course.name" type="text" class="w-full" />
                <x-jet-input-error for="name" />
            </div>

            <div class="mb-4">
                <x-jet-label value="Categoria" />
                <select wire:model="course.category_id" type="text" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm w-full">
                    <option value="">seleccione</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach

                </select>

                <x-jet-input-error for="category_id" />
            </div>

            <div class="mb-4">
                <x-jet-label value="slug" />
                <x-jet-input wire:model="course.slug" type="text" class="w-full" />
                <x-jet-input-error for="slug" />
            </div>

            <div class="mb-4">
                <x-jet-label value="Cargar Imagen" />
                <input id="" type="file" class="mb-4" wire:model="image" id="{{ $identificador }}" />
                <!--alert-->
                <div wire:loading wire:target='image'
                    class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-800"
                    role="alert">
                    <span class="font-medium">¡Imagen!</span> Espere un momento hasta que la imagen se haya procesado.
                </div>
                <!--imagen temporal-->
                @if ($image)
                    <img class="w-64 mb-4" src="{{ $image->temporaryUrl() }}">
                @else
                    <img class="w-64 mb-4" src="{{ $course->image }}">
                @endif
                <x-jet-input-error for="image" />
            </div>

            <div class="mb-4">
                <x-jet-label value="Descripción" />
                <x-jet-input wire:model="course.description" type="text" class="w-full" />
                <x-jet-input-error for="description" />
            </div>

        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$set('open', false)">
                Cancelar
            </x-jet-secondary-button>

            <x-jet-danger-button wire:click="save" wire:loading.attr="disabled" wire:target="save"
                class="disabled:opacity-25">
                Actualizar
            </x-jet-danger-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>
