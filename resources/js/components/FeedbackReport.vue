<template>
  <div class="card p-4 shadow">
    <h4 class="mb-3">รายงานสรุป Feedback</h4>

    <!-- ค่าเฉลี่ยคะแนน -->
    <p><b>ค่าเฉลี่ยคะแนน:</b> {{ average }}</p>

    <!-- Word Cloud -->
    <div v-if="wordCloudData.length" class="my-4">
      <h6>Word Cloud คำหลักที่พบบ่อย:</h6>
      <word-cloud
        :words="wordCloudData"
        :stopWords="stopWords"
        :minWeight="minWeight"
        :maxWords="maxWords"
      />
    </div>

    <!-- Export Buttons -->
    <div class="mb-3">
      <button @click="exportJSON" class="btn btn-success me-2">Export JSON</button>
      <button @click="exportCSV" class="btn btn-primary me-2">Export CSV</button>
      <button @click="exportFullJSON" class="btn btn-warning me-2">Export Full JSON</button>
      <button @click="exportFullCSV" class="btn btn-info">Export Full CSV</button>
    </div>

    <!-- Keywords List -->
    <div v-if="Object.keys(keywords).length" class="mb-4">
      <h6>คำหลักที่พบบ่อย (Top 10):</h6>
      <span
        v-for="(count, word) in keywords"
        :key="word"
        class="badge bg-info me-2"
      >
        {{ word }} ({{ count }})
      </span>
    </div>

    <!-- Feedback Table -->
    <table class="table mt-4" v-if="feedbacks.length">
      <thead>
        <tr>
          <th>ผู้ใช้</th>
          <th>คะแนน</th>
          <th>คอมเมนต์</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="f in feedbacks" :key="f.id">
          <td>{{ f.user_id ?? 'ไม่ระบุ' }}</td>
          <td>{{ f.rating }}</td>
          <td>{{ f.comment }}</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import axios from 'axios'
import WordCloud from './WordCloud.vue'

export default {
  props: ['sessionId'],
  components: { WordCloud },
  data() {
    return {
      average: 0,
      feedbacks: [],
      keywords: {},
      wordCloudData: [],
      stopWords: [
        'และ','คือ','มาก','ครับ','ค่ะ','ที่','ได้','ให้','เป็น','มี',
        'the','is','are','to','of','for','on','in'
      ],
      minWeight: 1,
      maxWords: 50
    }
  },
  async mounted() {
    try {
      const res = await axios.get(`/feedback/report/${this.sessionId}`)
      this.average = res.data.average
      this.feedbacks = res.data.feedbacks
      this.keywords = res.data.keywords

      this.wordCloudData = Object.entries(this.keywords).map(([word, count]) => ({
        text: word,
        weight: count
      }))
    } catch (error) {
      console.error('Error fetching feedback report:', error)
    }
  },
  methods: {
    // ✅ Filter WordCloud for display & export
    getFilteredWordCloud() {
      let filtered = this.wordCloudData
        .filter(w => !this.stopWords.includes(w.text))
        .filter(w => w.weight >= this.minWeight)
      return filtered.slice(0, this.maxWords)
    },

    // Export WordCloud only
    exportJSON() {
      const filtered = this.getFilteredWordCloud()
      const dataStr = JSON.stringify(filtered, null, 2)
      const blob = new Blob([dataStr], { type: 'application/json' })
      const url = URL.createObjectURL(blob)
      const a = document.createElement('a')
      a.href = url
      a.download = `feedback_keywords_${this.sessionId}.json`
      a.click()
      URL.revokeObjectURL(url)
    },

    exportCSV() {
      const filtered = this.getFilteredWordCloud()
      let csv = 'text,weight\n'
      filtered.forEach(w => {
        csv += `${w.text},${w.weight}\n`
      })
      const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' })
      const url = URL.createObjectURL(blob)
      const a = document.createElement('a')
      a.href = url
      a.download = `feedback_keywords_${this.sessionId}.csv`
      a.click()
      URL.revokeObjectURL(url)
    },

    // Export Full report (Feedback + Filtered Keywords)
    exportFullJSON() {
      const filtered = this.getFilteredWordCloud()
      const fullData = {
        average: this.average,
        feedbacks: this.feedbacks,
        keywords: filtered
      }
      const dataStr = JSON.stringify(fullData, null, 2)
      const blob = new Blob([dataStr], { type: 'application/json' })
      const url = URL.createObjectURL(blob)
      const a = document.createElement('a')
      a.href = url
      a.download = `feedback_full_${this.sessionId}.json`
      a.click()
      URL.revokeObjectURL(url)
    },

    exportFullCSV() {
      const filtered = this.getFilteredWordCloud()
      let csv = 'Feedbacks\nuser_id,rating,comment\n'
      this.feedbacks.forEach(f => {
        csv += `${f.user_id ?? ''},${f.rating},"${f.comment}"\n`
      })

      csv += '\nKeywords\ntext,weight\n'
      filtered.forEach(w => {
        csv += `${w.text},${w.weight}\n`
      })

      const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' })
      const url = URL.createObjectURL(blob)
      const a = document.createElement('a')
      a.href = url
      a.download = `feedback_full_${this.sessionId}.csv`
      a.click()
      URL.revokeObjectURL(url)
    }
  }
}
</script>

<style scoped>
.card {
  background-color: #fff;
  border-radius: 8px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}
</style>
