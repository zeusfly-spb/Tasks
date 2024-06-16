<template>
    <div class="container">
        <h1>To-Do List</h1>
        <div class="input-group">
            <input
                type="text"
                placeholder="Add a new task"
                v-model="name"
                @keyup.enter="addTask"
            />
            <button
                class="add-button"
                title="Add new task"
                :disabled="!valid"
                @click="addTask"
            >
                Add
            </button>
        </div>
        <table>
            <thead>
            <tr>
                <th>Name</th>
                <th
                    class="status-column"
                >
                    Status
                </th>
                <th
                    class="action-column"
                >
                    Action
                </th>
            </tr>
            </thead>
            <tbody>
            <Task
                v-for="(task, index) in tasks"
                :key="`task-${index}`"
                :task="task"
                @complete="showCompleteModal"
            />
            </tbody>
        </table>
        <CompleteModal
            v-model="completeModal"
            @completed="markCompleted"
        />
    </div>
</template>

<script setup>
import axios from "axios";
import {computed, onMounted, ref} from "vue";
import Task from "./Task.vue";
import CompleteModal from "./CompleteModal.vue";

const tasks = ref([]);
const name = ref('');
const completeModal = ref(null);

const valid = computed(() => !!name.value);

const fetchTasks = async () => {
    try {
        const {data} = await axios.get('/api/tasks/');
        tasks.value = data;
    } catch (e) {
        console.error(JSON.stringify(e))
    }
};
const addTask = async () => {
    if (!valid.value) {
        return;
    }
    try {
        const {data} = await axios.post('/api/tasks/', {name: name.value});
        tasks.value.unshift(data);
        name.value = '';
    } catch (e) {
        console.error(JSON.stringify(e));
    }
}
const showCompleteModal = id => completeModal.value = tasks.value.find(item => item.id === id);
const markCompleted = async () => {
    try {
        const {data} = await axios.post('/api/tasks/complete', {id: completeModal.value.id});
        tasks.value = tasks.value.map(item => item.id === data.id ? data : item);
    } catch (e) {
        console.error(JSON.stringify(e));
    }
}

onMounted(async () => await fetchTasks());
</script>

<style>
.container {
    background: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    max-width: 100%;
}

h1 {
    margin-bottom: 20px;
    text-align: center;
    color: #333;
}

.input-group {
    display: flex;
    margin-bottom: 20px;
}

.input-group input {
    flex: 1;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 4px;
}

.add-button {
    padding: 10px 15px;
    border-radius: 4px;
    margin-left: 10px;
    background: #28a745;
    color: #fff;
    cursor: pointer;
}

.add-button:hover {
    background: #218838;
}

.add-button:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}

ul {
    list-style: none;
    padding: 0;
}

li {
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 4px;
    margin-bottom: 10px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

li.completed span {
    text-decoration: line-through;
    color: #888;
}

li span {
    flex: 1;
    cursor: pointer;
}

li button {
    border: none;
    background: #dc3545;
    color: #fff;
    padding: 5px 10px;
    border-radius: 4px;
    cursor: pointer;
}

li button:hover {
    background: #c82333;
}
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

th, td {
    padding: 10px;
    border: 1px solid #ddd;
    text-align: left;
}

th {
    background-color: #f4f4f4;
}

td.completed {
    color: #218838;
}

td button {
    border: none;
    padding: 5px 10px;
    border-radius: 4px;
    cursor: pointer;
    margin: 2px;
}

.complete-btn {
    background: #28a745;
    color: #fff;
}

.complete-btn:hover {
    background: #218838;
}

.delete-btn {
    background: #dc3545;
    color: #fff;
}

.delete-btn:hover {
    background: #c82333;
}
.status-column {
    width: 10%;
    text-align: center;
}
.action-column {
    width: 10%;
    text-align: center;
}
.action-field {
    text-align: center;
}
</style>
