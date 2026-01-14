<x-app-layout>
    <x-page-header 
        title="Ajouter un équipement" 
        subtitle="Enregistrez un nouvel équipement dans l'inventaire"
        :centered="true"
    />

    <div class="mx-auto max-w-3xl">
        <x-card>
                <form method="POST" action="{{ route('equipments.store') }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                        <div>
                            <x-input-label for="name" :value="__('Nom')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name')" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="serial_number" :value="__('Numéro de série')" />
                            <x-text-input id="serial_number" name="serial_number" type="text" class="mt-1 block w-full" :value="old('serial_number')" required />
                            <x-input-error :messages="$errors->get('serial_number')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="brand" :value="__('Marque')" />
                            <x-text-input id="brand" name="brand" type="text" class="mt-1 block w-full" :value="old('brand')" required />
                            <x-input-error :messages="$errors->get('brand')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="model" :value="__('Modèle')" />
                            <x-text-input id="model" name="model" type="text" class="mt-1 block w-full" :value="old('model')" required />
                            <x-input-error :messages="$errors->get('model')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="category_id" :value="__('Catégorie')" />
                            <select id="category_id" name="category_id" class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 shadow-sm focus:border-indigo-500 dark:focus:border-indigo-400 focus:ring-indigo-500 dark:focus:ring-indigo-400" required>
                                <option value="">Sélectionner une catégorie</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="status" :value="__('Statut')" />
                            <select id="status" name="status" class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 shadow-sm focus:border-indigo-500 dark:focus:border-indigo-400 focus:ring-indigo-500 dark:focus:ring-indigo-400" required>
                                <option value="available" {{ old('status') == 'available' ? 'selected' : '' }}>Disponible</option>
                                <option value="assigned" {{ old('status') == 'assigned' ? 'selected' : '' }}>Affecté</option>
                                <option value="broken" {{ old('status') == 'broken' ? 'selected' : '' }}>En Panne</option>
                                <option value="scrapped" {{ old('status') == 'scrapped' ? 'selected' : '' }}>Rebut</option>
                            </select>
                            <x-input-error :messages="$errors->get('status')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="purchase_date" :value="__('Date d\'achat')" />
                            <x-text-input id="purchase_date" name="purchase_date" type="date" class="mt-1 block w-full" :value="old('purchase_date')" required />
                            <x-input-error :messages="$errors->get('purchase_date')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="warranty_duration" :value="__('Durée garantie (mois)')" />
                            <x-text-input id="warranty_duration" name="warranty_duration" type="number" class="mt-1 block w-full" :value="old('warranty_duration', 12)" min="0" max="120" required />
                            <x-input-error :messages="$errors->get('warranty_duration')" class="mt-2" />
                        </div>

                        <div class="md:col-span-2" x-data="{ 
                            imagePreview: null,
                            fileName: null,
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
                                :class="imagePreview ? 'border-indigo-400 dark:border-indigo-500' : ''"
                            >
                                <input 
                                    type="file" 
                                    id="image" 
                                    name="image" 
                                    accept="image/*" 
                                    class="hidden"
                                    @change="handleFileSelect"
                                />
                                
                                <div x-show="!imagePreview" class="flex flex-col items-center justify-center text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-500" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="mt-4 flex items-center justify-center text-sm leading-6 text-gray-600 dark:text-gray-400">
                                        <label for="image" class="relative cursor-pointer rounded-md bg-white dark:bg-gray-800 font-semibold text-indigo-600 dark:text-indigo-400 focus-within:outline-none focus-within:ring-2 focus-within:ring-indigo-600 dark:focus-within:ring-indigo-400 focus-within:ring-offset-2 hover:text-indigo-500 dark:hover:text-indigo-300">
                                            <span>Choisir un fichier</span>
                                            <input type="file" class="sr-only" />
                                        </label>
                                        <p class="pl-1">ou glissez-déposez</p>
                                    </div>
                                    <p class="text-xs leading-5 text-gray-600 dark:text-gray-400 mt-2">PNG, JPG, GIF jusqu'à 2MB</p>
                                </div>
                                
                                <div x-show="imagePreview" class="space-y-4">
                                    <div class="relative inline-block">
                                        <img :src="imagePreview" alt="Aperçu" class="h-48 w-auto mx-auto rounded-lg border border-gray-200 dark:border-gray-700 shadow-md">
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
                                    <p x-show="fileName" class="text-sm text-center text-gray-600 dark:text-gray-400" x-text="fileName"></p>
                                </div>
                            </div>
                            
                            <x-input-error :messages="$errors->get('image')" class="mt-2" />
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-4">
                        <x-button-secondary href="{{ route('equipments.index') }}">
                            Annuler
                        </x-button-secondary>
                        <x-button-primary type="submit">
                            Créer
                        </x-button-primary>
                    </div>
                </form>
        </x-card>
    </div>
</x-app-layout>
