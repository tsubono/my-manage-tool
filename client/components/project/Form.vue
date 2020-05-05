<template>
  <div class="card col-md-10 col-md-offset-1">
    <!-- .header -->
    <div class="header">
      <h4 class="title">案件情報</h4>
    </div>
    <!-- /.header -->
    <!-- .content -->
    <div class="content">
      <!-- form items -->
      <div class="row">
        <div class="col-md-12">
          <div class="form-group col-md-10 col-xs-12">
            <multiselect
              v-model="form.client"
              :options="clientOptions"
              label="name"
              track-by="id"
              placeholder="取引先"
            >
            </multiselect>
          </div>
          <fg-input
            type="text"
            class="col-md-10 col-xs-12"
            label="名前"
            v-model="form.name"
          >
          </fg-input>
          <div class="form-group col-md-10 col-xs-12">
            <label>内容</label>
            <textarea
              rows="5"
              class="form-control border-input"
              v-model="form.content"></textarea>
          </div>
          <fg-input
            type="text"
            class="col-md-10 col-xs-12"
            label="開始日"
            v-model="form.start_date">
          </fg-input>
          <fg-input
            type="text"
            class="col-md-10 col-xs-12"
            label="納期"
            v-model="form.limit_date">
          </fg-input>
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
              placeholder="ラベル">
            </multiselect>
          </div>
          <div class="form-group col-md-10 col-xs-12">
            <multiselect
              v-model="form.status"
              :options="statusOptions"
              label="name"
              track-by="id"
              placeholder="ステータス">
            </multiselect>
          </div>
        </div>
      </div>
      <!-- /form items -->
      <!-- buttons -->
      <div class="text-center actions">
        <button class="btn btn-default" @click="$router.push('/projects')">
          一覧に戻る
        </button>
        <button class="btn btn-info btn-fill btn-wd" @click="submit">
          {{ project.id === null ? "登録する" : "更新する" }}
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
      project: {
        type: Object,
        'default': () => ({
          id: null,
          client_id: null,
          name: null,
          content: null,
          start_date: null,
          limit_date: null,
          status_id: null,
        })
      },
      clientOptions: {
        type: Array,
        'default': () => []
      },
      statusOptions: {
        type: Array,
        'default': () => []
      },
      labelOptions: {
        type: Array,
        'default': () => []
      },
    },
    data() {
      return {
        form: this.project
      }
    },
    methods: {
      submit() {
        this.$emit('submit', this.project)
      },
      addLabel: function(newLabel) {
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
