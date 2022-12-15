<div wire:init="loadPosts">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Posts') }}
        </h2>
    </x-slot>
    <div class="max-w-7x1 mx-auto px-4 sm:px-6 lg:px-8 py-12">

        @if (session()->has('message'))
            <x-message />
        @endif

        <!---Table---->
        <x-table>
            <!--search-->
            <div class="px-6 py-4 flex items-center">
                <div class="flex items-center">
                    <span>Mostrar</span>
                    <select wire:model="cant"
                        class="mx-2 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                    <span>entradas</span>
                </div>
                <x-jet-input class="flex-1 mx-4" placeholder="buscar" type="text" wire:model="search" />
                {{-- @livewire('create-course') --}}
                <x-jet-danger-button wire:click="$set('open_edit', true)">
                    Crear Nuevo Post
                </x-jet-danger-button>
            </div>
            @if (count($posts))
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" wire:click="order('id')"
                                class="w-24 cursor-pointer px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                ID
                                @if ($sort == 'id')

                                    @if ($direction == 'asc')
                                        <i class="fas fa-sort-alpha-up-alt float-right mt-1"></i>
                                    @else
                                        <i class="fas fa-sort-alpha-down-alt float-right mt-1"></i>
                                    @endif
                                @else
                                    <i class="fas fa-sort float-right mt-1"></i>
                                @endif
                            </th>
                            <th scope="col" wire:click="order('course_id')"
                                class="cursor-pointer px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Curso
                                @if ($sort == 'course_id')

                                    @if ($direction == 'asc')
                                        <i class="fas fa-sort-alpha-up-alt float-right mt-1"></i>
                                    @else
                                        <i class="fas fa-sort-alpha-down-alt float-right mt-1"></i>
                                    @endif
                                @else
                                    <i class="fas fa-sort float-right mt-1"></i>
                                @endif
                            </th>

                            <th scope="col" wire:click="order('name')"
                                class="cursor-pointer px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Nombre
                                @if ($sort == 'name')

                                    @if ($direction == 'asc')
                                        <i class="fas fa-sort-alpha-up-alt float-right mt-1"></i>
                                    @else
                                        <i class="fas fa-sort-alpha-down-alt float-right mt-1"></i>
                                    @endif
                                @else
                                    <i class="fas fa-sort float-right mt-1"></i>
                                @endif
                            </th>

                            <th scope="col" wire:click="order('free')"
                                class="cursor-pointer px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Free
                                @if ($sort == 'free')

                                    @if ($direction == 'asc')
                                        <i class="fas fa-sort-alpha-up-alt float-right mt-1"></i>
                                    @else
                                        <i class="fas fa-sort-alpha-down-alt float-right mt-1"></i>
                                    @endif
                                @else
                                    <i class="fas fa-sort float-right mt-1"></i>
                                @endif
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($posts as $item)
                            <tr>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900">
                                        {{ $item->id }}
                                    </div>
                                </td>
        
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900">
                                        {{ $item->course_id }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900">
                                        {{ $item->name }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900">
                                        {{ $item->free }}
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    {{-- @livewire('edit-courses', ['course' => $course], key($course->id)) --}}


                                    <a wire:click="edit({{ $item }})"
                                        class="font-bold text-white py-2 px-4 rounded cursor-pointer bg-green-600 hover:bg-green-500">
                                        Editar <i class="fas fa-edit"></i>
                                    </a>
                                    <a class="font-bold text-white py-2 px-4 ml-2 rounded cursor-pointer bg-red-600 hover:bg-red-500"
                                        wire:click="confirmDelete ({{ $item->id }})" wire:loading.attr="disabled">
                                        Eliminar <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
                
                @if ($posts->hasPages())
                    <div class="px-6 py-3">
                        {{ $posts->links() }}
                    </div>
                @endif
            @else
                @if ($search)
                    <div class="px-6 py-4">
                        No existe ningun registro que coincida con la busqueda
                    </div>
                @else
                    <p class="py-20 text-center animate-ping">Cargando...</p>
                @endif

            @endif
            
        </x-table>
    </div>
    <x-jet-confirmation-modal wire:model="open_delete">
        <x-slot name="title">
            {{ __('Eliminar Post') }}
        </x-slot>

        <x-slot name="content">
            {{ __('¿Está seguro que desea eliminar el Post?') }}
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('open_delete', false)" wire:loading.attr="disabled">
                {{ __('Cancelar') }}
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-2" wire:click="delete ({{ $open_delete }})" wire:loading.attr="disabled">
                {{ __('Eliminar') }}
            </x-jet-danger-button>
        </x-slot>  
    </x-jet-confirmation-modal>

    <x-jet-dialog-modal wire:model="open_edit">
        <x-slot name="title">
            {{ isset( $this->post->id) ? 'Editar Post' : 'Crear Post' }}
        </x-slot>

        <x-slot name="content">

            <div class="mb-4">
                <x-jet-label value="Curso" />
                <select wire:model.difer="post.course_id" type="text"
                    class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm w-full">
                    <option value="">seleccione</option>
                    @foreach ($courses as $course)
                        <option value="{{ $course->id }}">{{ $course->name }}</option>
                    @endforeach

                </select>

                <x-jet-input-error for="post.course_id" />
            </div>

            <div class="mb-4">
                <x-jet-label value="Nombre" />
                <x-jet-input wire:model.difer="post.name" type="text" class="w-full"/>
                <x-jet-input-error for="post.name" />
            </div>

            <div class="mb-4">
                <x-jet-label value="free" />
                <x-jet-input wire:model.difer="post.free" type="text" class="w-full" />
                <x-jet-input-error for="post.free" />
            </div>

        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$set('open_edit', false)">
                Cancelar
            </x-jet-secondary-button>

            <x-jet-danger-button wire:click="update" wire:loading.attr="disabled" class="disabled:opacity-25">
                {{ isset( $this->post->id) ? 'Actualizar' : 'Guardar' }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>
