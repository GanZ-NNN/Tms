<template>
  <div ref="cloud" style="width:100%; height:300px;"></div>
</template>

<script>
import WordCloud from 'wordcloud'

export default {
  props: {
    words: {
      type: Array,
      required: true // [{ text: 'ดี', weight: 5 }, { text: 'เข้าใจง่าย', weight: 3 }]
    },
    stopWords: {
      type: Array,
      default: () => [
        'และ','คือ','มาก','ครับ','ค่ะ','ที่','ได้','ให้','เป็น','มี',
        'the','is','are','to','of','for','on','in'
      ]
    },
    minWeight: {
      type: Number,
      default: 1 // ✅ ค่า default = แสดงทุกคำ
    },
    maxWords: {
      type: Number,
      default: 50 // ✅ ค่า default = จำกัดสูงสุด 50 คำ
    }
  },
  mounted() {
    this.renderCloud()
  },
  methods: {
    renderCloud() {
      // ✅ กรอง stopWords และกรองตาม minWeight
      let filtered = this.words
        .filter(w => !this.stopWords.includes(w.text))
        .filter(w => w.weight >= this.minWeight)

      // ✅ จำกัดจำนวนคำสูงสุด
      filtered = filtered.slice(0, this.maxWords)

      // ✅ สร้าง WordCloud
      WordCloud(this.$refs.cloud, {
        list: filtered.map(w => [w.text, w.weight]),
        gridSize: 10,
        weightFactor: 12,
        fontFamily: 'Tahoma',
        rotateRatio: 0.5,
        backgroundColor: '#fff',
        color: () => {
          const colors = ['#1e40af', '#0284c7', '#10b981', '#f59e0b', '#ef4444']
          return colors[Math.floor(Math.random() * colors.length)]
        }
      })
    }
  }
}
</script>
