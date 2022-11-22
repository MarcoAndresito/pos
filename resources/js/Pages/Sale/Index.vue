<script setup>
import AppLayoutVue from '../../Layouts/AppLayout.vue';
import ActionSection from '@/Components/ActionSection.vue';
import DialogModal from '../../Components/DialogModal.vue';
import PrimaryButton from '../../Components/PrimaryButton.vue';
import SecondaryButton from '../../Components/SecondaryButton.vue';
import InputLabel from '../../Components/InputLabel.vue';
import TextInput from '../../Components/TextInput.vue';
import ImputError from '../../Components/InputError.vue';
import { ref } from 'vue';
import { useForm } from '@inertiajs/inertia-vue3';
const showDialogNewClient = ref(false);
const formNewClient = useForm({
    'nit': '',
    'name': '',
    'last_name': '',
    'birth_date': ''
});
const sendNewClient = () => {
    formNewClient.post(route('client.store'), {
        onSuccess: () => {
            showDialogNewClient.value = false;
        }
    });
};
</script>

<template>
    <AppLayoutVue>
        <template #header>
            <SecondaryButton class="m-2 py-2 px-4 bg-indigo-400 hover:bg-indigo-700 rounded"
                @click="showDialogNewClient = true">Nuevo Cliente</SecondaryButton>
        </template>
        <template #default>
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <ActionSection>
                    <template #title>Ventas</template>
                    <template #description>Ventas</template>
                    <template #content>formulario!</template>
                </ActionSection>
            </div>
        </template>
    </AppLayoutVue>

    <DialogModal v-bind:show="showDialogNewClient">
        <template #title>Nuevo Cliente</template>
        <template #content>
            <form @submit.prevent="sendNewClient">
                <div class="grid grid-cols-6 gap-6">
                    <div class="col-span-6 sm:col-span-4">
                        <InputLabel for="nit" value="Nit" />
                        <TextInput type="text" name="nit" id="nit" v-model="formNewClient.nit" class="w-full">
                        </TextInput>
                        <ImputError v-bind:message="formNewClient.errors.nit"></ImputError>
                    </div>
                    <div class="col-span-6 sm:col-span-4">
                        <InputLabel for="name" value="Nombre" />
                        <TextInput type="text" name="name" id="name" v-model="formNewClient.name" class="w-full">
                        </TextInput>
                        <ImputError v-bind:message="formNewClient.errors.name"></ImputError>
                    </div>
                    <div class="col-span-6 sm:col-span-4">
                        <InputLabel for="last_name" value="Apellido" />
                        <TextInput type="text" name="last_name" id="last_name" v-model="formNewClient.last_name"
                            class="w-full">
                        </TextInput>
                        <ImputError v-bind:message="formNewClient.errors.last_name"></ImputError>
                    </div>
                    <div class="col-span-6 sm:col-span-4">
                        <InputLabel for="birth_date" value="Fecha Nacimiento" />
                        <TextInput type="date" name="birth_date" id="birth_date" v-model="formNewClient.birth_date"
                            class="w-full">
                        </TextInput>
                        <ImputError v-bind:message="formNewClient.errors.birth_date"></ImputError>
                    </div>
                    <div class="col-span-6 text-end">
                        <PrimaryButton class="mr-2">Guardar</PrimaryButton>
                        <SecondaryButton @click="showDialogNewClient = false">Cancelar</SecondaryButton>
                    </div>
                </div>
            </form>
        </template>
    </DialogModal>
</template>
