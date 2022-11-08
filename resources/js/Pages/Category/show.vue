<script setup>
import AppLayout from '../../Layouts/AppLayout.vue'
import ActionSection from '../../Components/ActionSection.vue';
import DialogModal from '../../Components/DialogModal.vue';
import SecondaryButton from '../../Components/SecondaryButton.vue';
import { Link, useForm } from '@inertiajs/inertia-vue3';
import { ref } from 'vue';

const data = defineProps({
    category: Object
});

const form = useForm();

function enviar() {
    form.delete(route('category.destroy', data.category.id));
}

const showDialog = ref(false);
</script>
<template>
    <AppLayout>
        <template #header>titulo</template>
        <template #default>
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <ActionSection>
                    <template #title>Categoria</template>
                    <template #description>Categoria</template>
                    <template #content>
                        <p>Nombre: {{ category.name }}</p>
                        <p>Tipo: {{ category.type }}</p>
                        <Link class="m-2 py-2 px-4 bg-cyan-400 hover:bg-cyan-700 rounded text-white text-xs "
                            v-bind:href="route('category.index')" as="button">Volver</Link>
                        <SecondaryButton class="m-2 py-2 px-4 bg-green-400 hover:bg-green-500 rounded text-white"
                            @click="showDialog = true">Eliminar</SecondaryButton>
                    </template>
                </ActionSection>
            </div>
        </template>
    </AppLayout>

    <DialogModal v-bind:show="showDialog">
        <template #title>Eliminar</template>
        <template #content>¿Seguro de eliminar la categoria "{{ category.name }}"?</template>
        <template #footer>
            <SecondaryButton @click="enviar">Si</SecondaryButton>
            <!--<SecondaryButton @click="useForm().delete(route('category.destroy', category.id))">otro si</SecondaryButton>-->
            <SecondaryButton @click="showDialog = false">No</SecondaryButton>
        </template>
    </DialogModal>

</template>