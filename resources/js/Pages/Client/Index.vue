<script setup>
import AppLayoutVue from '../../Layouts/AppLayout.vue';
import ActionSection from '@/Components/ActionSection.vue';
</script>

<template>
    <AppLayoutVue>
        <template #header>
            Clientes
        </template>
        <template #default>
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <ActionSection>
                    <template #title>Cliente</template>
                    <template #description>Cliente</template>
                    <template #content>formulario!</template>
                </ActionSection>
            </div>
        </template>
    </AppLayoutVue>
</template>