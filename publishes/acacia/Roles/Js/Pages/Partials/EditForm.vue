<template>
    <TabView v-if="model?.can?.view">
        <TabPanel header="Basic Info">
            <form v-if="model?.can?.update" @submit.prevent="updateModel">
                <div class="">
                    <div class="my-2">
                        <label>Name</label>
                        <InputText class="block w-full" v-model="form.name" />
                    </div>
                    <div class="my-2">
                        <label>Guard Name</label>
                        <InputText
                            class="block w-full"
                            v-model="form.guard_name"
                        />
                    </div>
                </div>

                <div class="text-right min-w-[300px] pt-2 border-t-2">
                    <Button type="submit" icon="pi pi-check" label="Save" />
                </div>
            </form>
        </TabPanel>
        <TabPanel header="Assign Permissions">
            <AssignPerms :permissions="model?.perms" :role="model" />
        </TabPanel>
    </TabView>

    <Message v-else severity="error"
        >You are not authorized to perform this action</Message
    >
</template>
<script lang="ts">
import { defineComponent } from "vue";

export default defineComponent({
    name: "RoleEditForm",
});
</script>
<script setup lang="ts">
import Button from "primevue/button";
import { useForm, usePage } from "@inertiajs/inertia-vue3";
import { computed, defineEmits, nextTick, ref } from "vue";
import axios from "axios";
import route from "ziggy-js";
import Label from "@/Components/Label.vue";
import AssignPerms from "./AssignPerms.vue";
import { useToast } from "primevue/usetoast";
import { Inertia } from "@inertiajs/inertia";
import Message from "primevue/message";
import TabView from "primevue/tabview";
import TabPanel from "primevue/tabpanel";

import InputText from "primevue/inputtext";
const emit = defineEmits(["updated", "error"]);
const props = defineProps({ model: {} });
const flash = computed(() => usePage().props?.value?.flash) as any;
const existingTables = ref([]);
const showModal = ref(false);
const toast = useToast();
const model = props.model;
const form = useForm({ ...model });
const updateModel = async () => {
    form.put(route("acacia.auth.roles.update", model), {
        onSuccess: (res) => {
            const fl = res.props.flash as any;
            toast.add({
                severity: "success",
                summary: "Success",
                detail: fl?.success,
                life: 2000,
            });
            const payload = flash.value?.payload;
            emit("updated", { payload: payload });
        },
        onError: (errors) => {
            let msg =
                flash.value?.error ||
                errors?.message ||
                errors?.error ||
                errors ||
                "A server error occurred.";
            toast.add({
                severity: "error",
                summary: "Error",
                detail: msg,
                life: 3000,
            });
            const payload = flash.value?.payload;
            emit("error", { payload: payload, message: msg });
        },
        onFinish: (res) => {},
    });
};
</script>

<style scoped></style>
