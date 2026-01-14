<x-app-layout>
    <x-page-header 
        title="Modifier l'équipement" 
        subtitle="Mettez à jour les informations de l'équipement"
    />

    <div class="mx-auto max-w-3xl">
        <x-card>
                <form method="POST" action="{{ route('equipments.update', $equipment) }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                        <div>
                            <x-input-label for="name" :value="__('Nom')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $equipment->name)" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="serial_number" :value="__('Numéro de série')" />
                            <x-text-input id="serial_number" name="serial_number" type="text" class="mt-1 block w-full" :value="old('serial_number', $equipment->serial_number)" required />
                            <x-input-error :messages="$errors->get('serial_number')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="brand" :value="__('Marque')" />
                            <x-text-input id="brand" name="brand" type="text" class="mt-1 block w-full" :value="old('brand', $equipment->brand)" required />
                            <x-input-error :messages="$errors->get('brand')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="model" :value="__('Modèle')" />
                            <x-text-input id="model" name="model" type="text" class="mt-1 block w-full" :value="old('model', $equipment->model)" required />
                            <x-input-error :messages="$errors->get('model')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="category_id" :value="__('Catégorie')" />
                            <select id="category_id" name="category_id" class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 shadow-sm focus:border-indigo-500 dark:focus:border-indigo-400 focus:ring-indigo-500 dark:focus:ring-indigo-400" required>
                                <option value="">Sélectionner une catégorie</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $equipment->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="status" :value="__('Statut')" />
                            <select id="status" name="status" class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 shadow-sm focus:border-indigo-500 dark:focus:border-indigo-400 focus:ring-indigo-500 dark:focus:ring-indigo-400" required>
                                <option value="available" {{ old('status', $equipment->status) == 'available' ? 'selected' : '' }}>Disponible</option>
                                <option value="assigned" {{ old('status', $equipment->status) == 'assigned' ? 'selected' : '' }}>Affecté</option>
                                <option value="broken" {{ old('status', $equipment->status) == 'broken' ? 'selected' : '' }}>En Panne</option>
                                <option value="scrapped" {{ old('status', $equipment->status) == 'scrapped' ? 'selected' : '' }}>Rebut</option>
                            </select>
                            <x-input-error :messages="$errors->get('status')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="purchase_date" :value="__('Date d\'achat')" />
                            <x-text-input id="purchase_date" name="purchase_date" type="date" class="mt-1 block w-full" :value="old('purchase_date', $equipment->purchase_date->format('Y-m-d'))" required />
                            <x-input-error :messages="$errors->get('purchase_date')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="warranty_duration" :value="__('Durée garantie (mois)')" />
                            <x-text-input id="warranty_duration" name="warranty_duration" type="number" class="mt-1 block w-full" :value="old('warranty_duration', $equipment->warranty_duration)" min="0" max="120" required />
                            <x-input-error :messages="$errors->get('warranty_duration')" class="mt-2" />
                        </div>

                        <div class="md:col-span-2" x-data="{ 
                            imagePreview: null,
                            fileName: null,
                            currentImage: @js($equipment->image_path ? asset('storage/' . $equipment->image_path) : null),
                            handleFileSelect(event) {
                                const file = event.target.files[0];
                                if (file) {
                                    this.fileName = file.name;
                                    const reader = new FileReader();
                                    reader.onload = (e) => {
                                        this.imagePreview = e.target.result;
                                    };
                                    reader.readAsDataURL(file);
                                }
                            },
                            handleDrop(event) {
                                event.preventDefault();
                                const file = event.dataTransfer.files[0];
                                if (file && file.type.startsWith('image/')) {
                                    const input = document.getElementById('image');
                                    const dataTransfer = new DataTransfer();
                                    dataTransfer.items.add(file);
                                    input.files = dataTransfer.files;
                                    this.handleFileSelect({ target: { files: [file] } });
                                }
                            },
                            removeImage() {
                                this.imagePreview = null;
                                this.fileName = null;
                                document.getElementById('image').value = '';
                            }
                        }">
                            <x-input-label for="image" :value="__('Image')" />
                            
                            <div 
                                @dragover.prevent
                                @drop.prevent="handleDrop"
                                class="mt-1 relative border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-6 transition-colors hover:border-indigo-400 dark:hover:border-indigo-500"
                                :class="(imagePreview || currentImage) ? 'border-indigo-400 dark:border-indigo-500' : ''"
                            >
                                <input 
                                    type="file" 
                                    id="image" 
                                    name="image" 
                                    accept="image/*" 
                                    class="hidden"
                                    @change="handleFileSelect"
                                />
                                
                                <div x-show="!imagePreview && !currentImage" class="text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-500" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="mt-4 flex text-sm leading-6 text-gray-600 dark:text-gray-400">
                                        <label for="image" class="relative cursor-pointer rounded-md bg-white dark:bg-gray-800 font-semibold text-indigo-600 dark:text-indigo-400 focus-within:outline-none focus-within:ring-2 focus-within:ring-indigo-600 dark:focus-within:ring-indigo-400 focus-within:ring-offset-2 hover:text-indigo-500 dark:hover:text-indigo-300">
                                            <span>Choisir un fichier</span>
                                            <input type="file" class="sr-only" />
                                        </label>
                                        <p class="pl-1">ou glissez-déposez</p>
                                    </div>
                                    <p class="text-xs leading-5 text-gray-600 dark:text-gray-400 mt-2">PNG, JPG, GIF jusqu'à 2MB</p>
                                </div>
                                
                                <div x-show="currentImage && !imagePreview" class="space-y-4">
                                    <div class="relative inline-block">
                                        <img :src="currentImage" alt="Image actuelle" class="h-48 w-auto mx-auto rounded-lg border border-gray-200 dark:border-gray-700 shadow-md">
                                        <p class="mt-2 text-xs text-center text-gray-500 dark:text-gray-400">Image actuelle</p>
                                    </div>
                                    <div class="text-center">
                                        <label for="image" class="cursor-pointer inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg transition-colors">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                                            </svg>
                                            Remplacer l'image
                                        </label>
                                    </div>
                                </div>
                                
                                <div x-show="imagePreview" class="space-y-4">
                                    <div class="relative inline-block">
                                        <img :src="imagePreview" alt="Nouvel aperçu" class="h-48 w-auto mx-auto rounded-lg border border-gray-200 dark:border-gray-700 shadow-md">
                                        <button 
                                            type="button"
                                            @click="removeImage"
                                            class="absolute top-2 right-2 bg-red-500 hover:bg-red-600 text-white rounded-full p-1.5 shadow-lg transition-colors"
                                        >
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>
                                    </div>
                                    <p x-show="fileName" class="text-sm text-center text-gray-600 dark:text-gray-400" x-text="'Nouvelle image: ' + fileName"></p>
                                </div>
                            </div>
                            
                            <x-input-error :messages="$errors->get('image')" class="mt-2" />
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-4">
                        <x-button-secondary href="{{ route('equipments.show', $equipment) }}">
                            Annuler
                        </x-button-secondary>
                        <x-button-primary type="submit">
                            Enregistrer
                        </x-button-primary>
                    </div>
                </form>
            </x-card>
        </div>
    </div>
</x-app-layout>
