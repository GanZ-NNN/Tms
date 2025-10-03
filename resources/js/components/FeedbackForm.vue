<!-- resources/js/components/FeedbackForm.vue -->
<template>
  <div class="card p-4 shadow">
    <h4 class="mb-3">แบบประเมินหลังอบรม</h4>

    <!-- Rating -->
    <div class="mb-3">
      <label class="form-label">ให้คะแนน:</label>
      <div>
        <span v-for="n in 5" :key="n" class="me-2">
          <i class="bi"
             :class="n <= rating ? 'bi-star-fill text-warning' : 'bi-star text-muted'"
             style="font-size: 1.5rem; cursor: pointer;"
             @click="rating = n"></i>
        </span>
      </div>
    </div>

    <!-- Comment -->
    <div class="mb-3">
      <label class="form-label">ข้อเสนอแนะเพิ่มเติม:</label>
      <textarea v-model="comment" class="form-control" rows="3"></textarea>
    </div>

    <!-- Submit -->
    <button @click="submitFeedback" class="btn btn-primary">
      บันทึกแบบประเมิน
    </button>

    <div v-if="message" class="alert alert-success mt-3">
      {{ message }}
    </div>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  props: ['sessionId'],
  data() {
    return {
      rating: 0,
      comment: '',
      message: ''
    }
  },
  methods: {
    async submitFeedback() {
      try {
        const res = await axios.post('/feedback', {
          session_id: this.sessionId,
          rating: this.rating,
          comment: this.comment
        })
        this.message = res.data.message
        this.rating = 0
        this.comment = ''
      } catch (err) {
        console.error(err)
      }
    }
  }
}
</script>
