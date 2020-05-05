<template>
  <div class="card col-md-10 col-md-offset-1">
    <!-- .header -->
    <div class="header">
      <h4 class="title">取引先情報</h4>
    </div>
    <!-- /.header -->
    <!-- .content -->
    <div class="content">
      <!-- form items -->
      <div class="row">
        <!-- .icon-area -->
        <div class="icon-area col-md-4 col-xs-11 col-xs-offset-1">
          <img
            :src="$utility.getImageUrl(form.icon_path)"
            class="round-img big"
            v-if="form.icon_path !== null"
          >
          <img
            :src="$utility.getImageUrl()"
            class="round-img big"
            v-else
          >
          <a class="edit-icon" @click="editIcon">
            <span class="ti-pencil"></span>
          </a>
        </div>
        <!-- /.icon-area -->
        <div class="col-md-7 col-xs-12">
          <fg-input
            type="text"
            class="col-md-8 col-xs-12"
            label="名前"
            v-model="form.name"
          >
          </fg-input>
          <fg-input
            type="text"
            class="col-md-8 col-xs-12"
            label="住所"
            v-model="form.address"
          >
          </fg-input>
          <fg-input
            type="text"
            class="col-md-8 col-xs-12"
            label="url"
            v-model="form.url"
          >
          </fg-input>
        </div>
        <div class="form-group col-md-10 col-xs-12">
          <label>メモ</label>
          <textarea
            rows="5"
            class="form-control border-input"
            v-model="form.note"
          >
          </textarea>
        </div>
        <div class="form-group col-md-10 col-xs-12">
          <multiselect
            v-model="form.labels"
            :options="labelOptions"
            open-direction="top"
            multiple
            taggable
            label="name"
            track-by="id"
            @tag="addLabel"
            tag-placeholder="新しいラベルを作成"
            placeholder="ラベル"
          >
          </multiselect>
        </div>
      </div>
      <!-- /form items -->
      <!-- buttons -->
      <div class="text-center actions">
        <button class="btn btn-default" @click="$router.push('/clients')">
          一覧に戻る
        </button>
        <button class="btn btn-info btn-fill btn-wd" @click="submit">
          {{ client.id === null ? "登録する" : "更新する" }}
        </button>
      </div>
      <!-- /buttons -->
    </div>
    <!-- /.content -->
  </div>
</template>

<script>
  export default {
    layout: "dashboard",
    props: {
      client: {
        type: Object,
        'default': () => ({
          id: null,
          name: null,
          postal_code: null,
          address: null,
          url: null,
          note: null,
          labels: [],
        })
      },
      labelOptions: {
        type: Array,
        'default': () => []
      }
    },
    data() {
      return {
        form: this.client,
      }
    },
    methods: {
      submit() {
        this.$emit('submit', this.client)
      },
      editIcon() {
        this.$emit('editIcon')
      },
      addLabel: function (newLabel) {
        const label = {
          id: newLabel.substring(0, 2) + Math.floor((Math.random() * 10000000)),
          name: newLabel,
        };
        this.labelOptions.push(label);
        this.form.labels.push(label);
      },
    }
  }
</script>

<style lang="scss" scoped>
  .icon-area {
    text-align: center;
    padding-top: 15px;

    .edit-icon {
      position: relative;
      top: 70px;
      right: 45px;
      cursor: pointer;
      font-size: 20px;
      border-radius: 50%;
      background: #ABB9BF;
      padding: 10px;
      color: #fff;

      &:hover {
        opacity: 0.9;
      }
    }
  }

  .actions {
    margin: 15px auto;
  }
</style>
