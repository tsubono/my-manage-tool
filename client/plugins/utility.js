import axios from 'axios'
import {notify} from '~/components/UIComponents/NotificationPlugin';

class Utility {
  constructor (axios, store) {
    this.$axios = axios;
    this.$store = store;
  }

  /**
   * 編集権限チェック
   * NGの場合はnotify表示
   *
   * @param notifications
   * @param user
   * @returns {boolean}
   */
  chkCanEdit = (notifications, user) => {
    if (!user.can_edit) {
      notifications.notify(
        {
          message: '<h4>Sorry...</h4><p>編集権限がありません</p>',
          icon: 'ti-face-sad',
          horizontalAlign: 'center',
          verticalAlign: 'top',
          type: 'danger',
        });
      return false;
    }
    return true;
  };

  /**
   * セレクトボックス用の取引先一覧を取得
   *
   * @param clients
   * @returns {Array}
   */
  getClientOptions = (clients) => {
    let options = [];
    clients.map(client => {
      options.push({id: client.id, name: client.name});
    });
    return options;
  };

  /**
   * セレクトボックス用の案件一覧を取得
   *
   * @param projects
   * @returns {Array}
   */
  getProjectOptions = (projects) => {
    let options = [];
    projects.map(project => {
      options.push({id: project.id, name: project.name});
    });
    return options;
  };

  /**
   * セレクトボックス用のステータス一覧を取得
   *
   * @param statuses
   * @returns {Array}
   */
  getStatusOptions = (statuses) => {
    let options = [];
    statuses.map(status => {
      options.push({id: status.id, name: status.name});
    });
    return options;
  };

  /**
   * imgタグ用の画像URLを取得
   * process.env.APP_URL = ApiのURL
   *
   * @param path
   * @returns {string}
   */
  getImageUrl = (path) => {
    return process.env.APP_URL + "/" + (path ? path : 'img/icon-no-image.png');
  }
}

export default ({ store }, inject) => {
  inject('utility', new Utility(axios, store))
}
