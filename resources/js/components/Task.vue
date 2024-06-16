<template>
    <tr>
        <td>
            {{ task.name }}
        </td>
        <td
            :class="{completed: task.completed}"
        >
            {{ `${task.completed ? 'Completed' : 'Not completed'}` }}
        </td>
        <td
            class="action-field"
        >
            <div>
                <button
                    v-if="!task.completed"
                    class="complete-btn"
                    title="Mark task as completed"
                    @click="markCompleted"
                >
                    <FontAwesomeIcon :icon="['fas', 'check']" />
                </button>
                <button
                    class="delete-btn"
                    title="Remove task"
                >
                    <FontAwesomeIcon :icon="['fas', 'trash']" />
                </button>
            </div>
        </td>
    </tr>
</template>

<script setup>
import {toRefs} from "vue";

const emits = defineEmits(['complete', 'remove']);
const props = defineProps({task: {type: Object, default: () => ({})}});
const {task} = toRefs(props);

const markCompleted = () => emits('complete', task.value.id);
</script>
