<script lang="ts" setup>
import { computed, reactive, ref, watch } from 'vue'
import { router, useForm } from '@inertiajs/vue3'

const props = defineProps({
  deliveries: Object, // tableau de produits { id, name, price },
  data:Object
})

// Formulaire Inertia avec products réactif

// console.log(props.deliveries);
const loading = ref(false)
let initial = (JSON.parse(JSON.stringify(props.deliveries)) ?? {})
console.log('====================================');
console.log();
console.log('====================================');
let product = reactive({...structuredClone(initial)})

// let product = reactive<Array<any>>(JSON.parse(JSON.stringify(props.deliveries ?? [])))
// let product = reactive<Array<any>>(JSON.parse(JSON.stringify(props.deliveries ?? [])))

// JSON.parse(JSON.stringify(props.deliveries?.items))
  // watch(()=>props,(value)=>{
  //   console.log('====================================');
  //   console.log(value);
  //   console.log('====================================');
  //   // product= JSON.parse(JSON.stringify(props.deliveries?.items ?? []))
  // },{deep:true,immediate:true})
  // console.log(props.deliveries?.items);

// Soumission avec validation et alertes
router.on('invalid', (event) => {
    console.log('Erreur HTTP:', event.detail.response.status)
    console.log('Message:', event.detail.response)
})
const submitForm = () => {
  loading.value = true
  router.post(`/deliveries/quantity/${props.data.uuid}`, product, {
    preserveState:true,
        onSuccess: (page) => {
            // console.log('====================================');
            console.log(page);
            // console.log('====================================');
            // Réinitialiser manuellement les données du formulaire
            // form.reset()
        },
        onError: (errors) => {
            console.log('Validation errors:', errors)
        },
        onFinish:()=>{
          loading.value =false
          my_modal_3.close()

        }
    })
}

const cancel=()=>{
    Object.assign(product, {...initial})
    my_modal_3.close()
}
</script>

<template>
  <div>
    <dialog id="my_modal_3" class="modal">
      <div class="modal-box max-w-2xl p-0">
        <form method="dialog">
          <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
        </form>
        <!-- <pre> {{ product }}</pre> -->
        <h3 class="text-lg p-5 font-bold mb-4">Magnage Quantity delivery</h3>
        <form action="" @submit.prevent="submitForm" class="w-full">
            <div class="w-full px-5 flex flex-col items-start gap-2">
            <!-- Sélection agent de liaison -->
              <!-- <pre>  {{ product }}</pre> -->
            <!-- products -->
            <!-- <h2 class="font-medium">Products</h2> -->
            <!-- Formulaire dynamique -->
            <div class="w-full">
              <div class="w-full grid grid-cols-3 mb-2">
                <div class="">Item</div>
                <div>Qty ordered</div>
                <div>Qty received</div>
              </div>
              <div v-for="(item, index) in product?.items" :key="index" 
                class="grid grid-cols-3  gap-2  rounded-md w-full items-center  mb-2">
                <div class="w-full ">
                  <input
                    v-model="item.name"
                    type="text"
                    placeholder="item"
                    class="input w-full read-only:bg-gray-50"
                    required
                    readonly
                  />
                  <!-- <span v-if="form.errors[`products.${index}.quantity`]" class="text-red-500 text-sm">
                    {{ form.errors[`products.${index}.quantity`] }}
                  </span> -->
                </div>

                  <div class="w-full ">
                    <input
                      v-model.number="item.quantity_ordered"
                      type="number"
                      min="0"
                      placeholder="Price"
                      class="input w-full read-only:bg-gray-50"
                      readonly
                      required
                    />
                    <!-- <span v-if="form.errors[`products.${index}.price`]" class="text-red-500 text-sm">
                      {{ form.errors[`products.${index}.price`] }}
                    </span> -->
                  </div>
                  <div class="w-full ">
                    <!-- {{ item.quantity_received }} -->
                    <input
                      v-model.number="item.quantity_received"
                      type="number"
                      min="0"
                      :max="item.quantity_ordered"
                      placeholder="Price"
                      class="input w-full"
                      required
                    />
                    <!-- <span v-if="form.errors[`products.${index}.price`]" class="text-red-500 text-sm">
                      {{ form.errors[`products.${index}.price`] }}
                    </span> -->
                  </div>
              </div>

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
            {{ loading ? 'Loading...' : 'Submit' }}
          </button>
        </div>
        </form>
      </div>
    </dialog>
  </div>
</template>
