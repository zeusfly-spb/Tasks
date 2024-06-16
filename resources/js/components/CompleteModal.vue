<template>
  <div
    v-if="visible"
    class="modal-overlay"
    style="font-size: 16px"
    @click="close"
  >
    <div class="modal-content" @click.stop>
        <p>Are you sure you want to mark the task <strong>"{{ props.modelValue.name }}"</strong> as completed?</p>
        <div class="modal-buttons">
            <button
                class="delete-btn"
                @click="close"
            >
                Cancel
            </button>
            <button
                class="complete-btn"
                @click="markCompleted"
            >
                Ok
            </button>
        </div>
    </div>
  </div>
</template>

<script setup>
import {computed} from "vue";

const props = defineProps({modelValue: {type: Object, default: null}});
const emit = defineEmits(['update:modelValue', 'completed']);

const visible = computed({
    get: () => !!props.modelValue,
    set: val => emit('update:modelValue', null)
});

const close = () => visible.value = false;
const markCompleted = () => {
    emit('completed');
    close();
}
</script>

<style scoped>
.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
}
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 1000;
}
.modal-content {
  background: white;
  padding: 20px;
  border-radius: 5px;
  position: relative;
  min-width: 540px;
}
.modal-buttons {
    text-align: right;
    margin-top: 20px;
}

.modal-buttons button {
    padding: 10px 20px;
    margin-left: 10px;
    cursor: pointer;
    border-radius: 4px;
    border: none;
}

</style>
