<script setup>
import AppLayoutVue from '../../Layouts/AppLayout.vue';
import FormSection from '../../Components/FormSection.vue';
import InputLabel from '../../Components/InputLabel.vue';
import TextInput from '../../Components/TextInput.vue';
function enviar() {

}
</script>
<template>
    <AppLayoutVue>
        <template #header>
            Formulario para crear nueva categoria
        </template>
        <template #default>
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <FormSection @submitted="enviar()">
                    <template #title>titulo</template>
                    <template #description>descripcion</template>
                    <template #form>
                        <div class="col-span-6 sm:col-span-4">
                            <InputLabel for="name" value="Nombre" />
                            <TextInput type="text" name="name" id="name"></TextInput>
                        </div>
                        <div class="col-span-6 sm:col-span-4">
                            <InputLabel for="type" value="Tipo" />
                            <input type="text" name="type" id="type">
                            <span></span>
                        </div>
                    </template>
                    <template #actions>botones</template>
                </FormSection>
            </div>
        </template>
    </AppLayoutVue>
</template>