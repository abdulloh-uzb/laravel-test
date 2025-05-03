<script setup>
import { ref } from 'vue'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import axios from 'axios'

const props = defineProps({
  questions: Array
})

const currentQuestionIndex = ref(0)
const selectedAnswer = ref(null)
const answers = ref([])
const correctAnswers = ref(null)
const quizFinished = ref(false)

function selectAnswer(answer) {
  selectedAnswer.value = answer

  answers.value.push({
    question: props.questions[currentQuestionIndex.value].question,
    selected: answer
  })

  setTimeout(() => {
    if (currentQuestionIndex.value + 1 < props.questions.length) {
      currentQuestionIndex.value++
      selectedAnswer.value = null
    } else {
      axios.post('/submit-answers', {
        answers: answers.value
      })
      .then(response => {
        correctAnswers.value = response.data.correct
        quizFinished.value = true
      })
      .catch(error => {
        console.error('Xatolik:', error)
      })
    }
  }, 500)
}
</script>

<template>
  <AuthenticatedLayout>
    <template #header>
      <h2 class="text-2xl font-bold text-gray-800">Quiz</h2>
    </template>

    <div class="max-w-xl mx-auto bg-white shadow-xl rounded-xl p-6" style="margin-top: 30px">
      <div v-if="!quizFinished">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">
          {{ props.questions[currentQuestionIndex].fullQuestion }}
        </h3>

        <div class="space-y-3">
          <button
            v-for="variant in props.questions[currentQuestionIndex].variants"
            :key="variant"
            @click="selectAnswer(variant)"
            :disabled="selectedAnswer"
            class="w-full py-2 px-4 border rounded-lg text-left transition-all duration-300 border-gray-300 hover:bg-gray-100"
          >
            {{ variant }}
          </button>
        </div>
      </div>

      <div v-else class="text-center">
        <h3 class="text-2xl font-bold text-gray-700 mb-4">Tugadi!</h3>
        <p class="text-lg">Siz barcha savollarga javob berdingiz.</p>
        <p class="text-green-600 font-semibold">
          To‘g‘ri javoblar soni: {{ correctAnswers }} / {{ props.questions.length }}
        </p>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
