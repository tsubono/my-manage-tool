<template>
  <div id="memo-list">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <!-- .add-button -->
            <div class="text-right add-button">
              <button class="btn btn-primary" @click="showMemoModal(item, true)">
                <span class="ti-plus"></span>
              </button>
            </div>
            <!-- /.add-button -->
            <!-- memo list -->
            <div class="row list">
              <div class="col-lg-4 col-sm-6" v-for="(item, index) in memos" :key="index">
              <div class="card item" @click="showMemoModal(item)">
                <div class="content">
                  {{ item.title }}
                </div>
              </div>
            </div>
            </div>
            <!-- /memo list -->
          </div>
        </div>
      </div>
    <MemoModal
      v-if="isShowMemoModal"
      :item="showModalItem"
      :isNew="isNew"
      @close="closeMemoModal()"
    />
  </div>
</template>

<script>
  import { mapState } from 'vuex'
  import MemoModal from '~/components/modal/MemoModal'

  export default {
    layout: 'default',
    components: {
      MemoModal,
    },
    head() {
      return {
        title: 'メモ一覧',
      }
    },
    async fetch ({ store }) {
      await store.dispatch('memo/fetch');
    },
    computed: {
      ...mapState('memo', ['memos']),
    },
    data() {
      return {
        isShowMemoModal: false,
        showModalItem: [],
        isNew: false,
      }
    },
    methods: {
      showMemoModal(item, isNew = false) {
        this.isShowMemoModal = true;
        this.showModalItem = item;
        this.isNew = isNew;
      },
      closeMemoModal() {
        this.isShowMemoModal = false;
        this.showModalItem = {};
      },
    }
  }
</script>

<style lang="scss" scoped>
  #memo-list {
    .list {
      margin: 10px auto;
      min-height: 450px;

      .item {
        height: 100px;
        cursor: pointer;
        padding:10px;
        margin-bottom: 30px;
        -webkit-transform: rotate(4deg);
        -moz-transform: rotate(4deg);
        -o-transform: rotate(4deg);
        background-color:#faf7e0;
        color:#908a60;
        -moz-box-shadow: -1px 1px 3px rgba(0, 0, 0, 0.25);
        -webkit-box-shadow: -1px 1px 3px rgba(0, 0, 0, 0.25);
        box-shadow: -1px 1px 3px rgba(0, 0, 0, 0.25);
        box-sizing:border-box;

        .content {
          border-bottom: 1px dotted;
        }

        &::after {
          content: url(/img/tape.png);
          position: absolute;
          top:-15px;
          left:33%;
        }

        &:hover {
          -webkit-transform: rotate(-2deg);
          -moz-transform: rotate(-2deg);
          -o-transform: rotate(-2deg);
        }

        @media (max-width: 480px) {
          -webkit-transform: rotate(0deg);
          -moz-transform: rotate(0deg);
          -o-transform: rotate(0deg);
        }
      }
    }

    .add-button {
      padding: 10px;
    }
  }
</style>
