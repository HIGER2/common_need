<script lang="ts" setup>
import { computed, ref } from 'vue'
import { useForm } from '@inertiajs/vue3'

const props = defineProps({
  productSelect: Array, // tableau de produits { id, name, price },
  budgetOfficer: Array // tableau d’agents de liaison { id, name
})

// Formulaire Inertia avec products réactif
const initProduct = { id: null, product: '',supplier_id:"", quantity: 1, price: 0 }
const selectedProductId = ref("");

const form = useForm({
  budget_officer_id: '',
  products: [
    {...initProduct}
  ]
})
const loading = ref(false)
// Ajouter un produit
const addProduct = () => {
  form.products.push({...initProduct})
  console.log('====================================');
  console.log(form.products);
  console.log('====================================');
}

// Supprimer un produit
const removeProduct = (index: number) => {
  form.products.splice(index, 1)
}

// Sélection d’un produit dans le select
const onSelectProduct = (productId,item) => {
  console.log('====================================');
  console.log(form.products);
  console.log('====================================');
    const existing = form.products.filter(p => p.id === productId)

    if (existing.length > 1) {
      alert("Produit déjà sélectionné")
      item.id = null
      return
    }

    const selected = props.productSelect.find(p => p.id == productId)

    if (selected) {
      item.product = selected.name
      item.price = Number(selected.price) || 0
      item.supplier_id = selected.supplier_id || null
    }
}

// Calcul récapitulatif
const totalQuantity = computed(() =>
  form.products.reduce((sum, p) => sum + (p.quantity || 0), 0)
)
const totalProducts = computed(() => form.products.length)
const totalAmount = computed(() =>
  form.products.reduce((sum, p) => sum + ((p.price || 0) * (p.quantity || 0)), 0)
)

// Soumission avec validation et alertes
const submitForm = () => {
  const errors: string[] = []
  if (form.budget_officer_id === '') {
    errors.push('Veuillez sélectionner un agent de liaison.')
  }
    if (!confirm('Are you sure you want to continue?')) {
      return;
    }
  form.products.forEach((item, index) => {
    if (!item.id) errors.push(`Produit #${index + 1} non sélectionné`)
    if (!item.quantity || item.quantity <= 0) errors.push(`Quantité invalide pour le produit #${index + 1}`)
    if (!item.price || item.price <= 0) errors.push(`Prix invalide pour le produit #${index + 1}`)
  })

  // return  
  if (errors.length) {
    alert(errors.join('\n'))
    return
  }

  loading.value = true
  form.post('/api/admin/purchase-requests', {
      preserveState: true,
      preserveScroll: true,
      forceFormData: true,
    onSuccess: () => {
      alert('Request added successfully and email sent to budget officer.')
      form.products = [{ id: null, product: '', supplier_id: "", quantity: 0, price: 0 }]
      form.budget_officer_id = ''
      loading.value = false
      my_modal_3.close()
    },
    onError:(error)=>{
      loading.value = false
      console.log('====================================');
      console.log(error);
      console.log('====================================');
    }
  })
}

const cancel=()=>{
  form.products = [{...initProduct}]
  my_modal_3.close()
}
</script>
<template>
  <div>
    <dialog id="my_modal_3" class="modal">
      <div class="modal-box max-w-xl p-0">
        <form method="dialog">
          <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
        </form>
        <!-- <pre> {{ products }}</pre> -->
        <h3 class="text-lg p-5 font-bold mb-4">New request</h3>
        <form action="" @submit.prevent="submitForm" class="w-full">
                <div class="w-full p-5 flex flex-col items-start gap-5">
            <!-- Sélection agent de liaison -->
            <div class="w-full">
              <label for="" class="font-medium mb-2">Budget officer</label>
              <select
                v-model="form.budget_officer_id"
                class="select w-full"
                required
              >
                <option value="" disabled>Select budget officer</option>
                <option
                  v-for="officer in budgetOfficer"
                  :key="officer.id"
                  :value="officer.id"
                >
                  {{ officer.name }}
                </option>
              </select>
            </div>

            <!-- products -->
            <h2 class="font-medium">Products</h2>
            <!-- Formulaire dynamique -->
            <div class="w-full flex justify-between items-center min-h-1 border-b border-gray-200">
                <div class="flex justify-between gap-2 items-center">
                  <span>Items :</span>
                  <span>{{ totalProducts }}</span>
                </div>
                <div class="flex justify-between  gap-2 items-center">
                  <span>Quantity :</span>
                  <span>{{ totalQuantity }}</span>
                </div>
                <div class="flex justify-between  gap-2 items-center">
                  <span>Total amount :</span>
                  <span>{{ totalAmount }}</span>
                </div>
            </div>
            
            <div class="w-full">
              <div class="w-full grid grid-cols-8 mb-2">
                <div class="col-span-4">Item</div>
                <div>Qty</div>
                <div class="col-span-2">Price</div>
                <!-- <div></div> -->
              </div>
              <div v-for="(item, index) in form.products" :key="index" class="grid grid-cols-8 gap-2  rounded-md w-full items-center  mb-2">
                <!-- Product Name -->
                <div class="w-full col-span-4">
                  <!-- <label for="" class="font-medium">Item</label> -->
                <select
                    v-model="item.id"
                    @change="onSelectProduct(item.id, item)"
                    class="select w-full"
                    required
                  >
                    <option value="" disabled>Product</option>

                    <option
                      v-for="product in productSelect"
                      :key="product.id"
                      :value="product.id"
                      :disabled="form.products.some(p => p.id === product.id)"
                    >
                      {{ product.name }}
                    </option>
                  </select>


                  <!-- <input
                    v-model="item.product"
                    type="text"
                    placeholder="Product"
                    class="input w-full"
                    required
                  /> -->
                  <span v-if="form.errors[`products.${index}.product`]" class="text-red-500 text-sm">
                    {{ form.errors[`products.${index}.product`] }}
                  </span>
                </div>

                <!-- Quantity -->
                <div class="w-full">
                  <!-- <label for="" class="font-medium">Qty</label> -->
                  <input
                    v-model.number="item.quantity"
                    type="number"
                    min="1"
                    placeholder="Quantity"
                    class="input w-full"
                    required
                  />
                  <span v-if="form.errors[`products.${index}.quantity`]" class="text-red-500 text-sm">
                    {{ form.errors[`products.${index}.quantity`] }}
                  </span>
                </div>

                <!-- Price -->
                <div class="w-full col-span-2">
                  <!-- <label for="" class="font-medium">Price</label> -->
                  <input
                    v-model.number="item.price"
                    type="number"
                    min="0"
                    placeholder="Price"
                    class="input w-full"
                    readonly
                    required
                  />
                  <span v-if="form.errors[`products.${index}.price`]" class="text-red-500 text-sm">
                    {{ form.errors[`products.${index}.price`] }}
                  </span>
                </div>

                <!-- Supprimer -->
                <button 
                :disabled="form.products.length ==1"
                type="button" @click="removeProduct(index)" 
                  class="btn !disabled:cursor-not-allowed cursor-pointer btn-ghost border-0 max-w-max bg-red-50 text-xl text-red-700">
                  <i class="uil uil-times"></i>
                </button>
              </div>

              <button type="button" class="cursor-pointer font-medium p-1 text-sm bg-gray-200  w-full  text-center rounded-lg mt-3" @click="addProduct">
                Add item
              </button>
            </div>

            <!-- Récapitulatif -->
            <!-- <div class="w-[350px] space-y-3 p-4 min-h-1 border border-gray-200 rounded-lg">
              <div class="flex justify-between items-center">
                <span>Products</span>
                <span>{{ totalProducts }}</span>
              </div>
              <div class="flex justify-between items-center">
                <span>Quantity</span>
                <span>{{ totalQuantity }}</span>
              </div>
              <div class="flex justify-between items-center">
                <span>Total amount</span>
                <span>{{ totalAmount }}</span>
              </div>
            </div> -->
          </div>

          <!-- Bouton de soumission -->
        <div class="w-full p-5 sticky bottom-0 bg-white flex items-center justify-end gap-4"  >
            <button
            
            type="button"
            class="px-4 max-w-max  mt-5 btn text-primarys  rounded-md"
            @click="cancel"
          >
            Cancel
          </button>
          <button
            :disabled="loading"
            type="submit"
            class="px-4 max-w-max disabled:cursor-not-allowed disabled:opacity-90  mt-5 btn bg-primarys text-white rounded-md"
          >
            {{ loading ? 'Loading...' : 'Add request' }}
          </button>
        </div>
        </form>
      </div>
    </dialog>
  </div>
</template>
