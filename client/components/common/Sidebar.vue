<template>
  <side-bar type="sidebar">
    <sidebar-link to="/">
      <i class="ti-panel"></i>
      <p>Top</p>
    </sidebar-link>
    <sidebar-link
      to="/clients"
      :class="{ 'active': $nuxt.$route.name.match(/clients/) }">
      <i class="ti-face-smile"></i>
      <p>取引先一覧</p>
    </sidebar-link>
    <sidebar-link
      to="/projects"
      :class="{ 'active': $nuxt.$route.name.match(/projects/) }">
      <i class="ti-crown"></i>
      <p>案件一覧</p>
    </sidebar-link>
    <sidebar-link
      to="/todos"
      :class="{ 'active': $nuxt.$route.name.match(/todos/) }">
      <i class="ti-arrow-circle-down"></i>
      <p>TODO</p>
    </sidebar-link>
    <sidebar-link
      to="/memos"
      :class="{ 'active': $nuxt.$route.name.match(/memos/) }">
      <i class="ti-pencil"></i>
      <p>メモ</p>
    </sidebar-link>
    <sidebar-link
      :to="{ name:'sales-year-month', params: { year: new Date().getFullYear(), month: new Date().getMonth() + 1 } }"
      :class="{ 'active': $nuxt.$route.name === 'sales-year-month' }">
      <i class="ti-medall"></i>
      <p>売上</p>
    </sidebar-link>
    <sidebar-link
      :to="{ name:'sales-year-analysis', params: { year: new Date().getFullYear() } }"
      :class="{ 'active': $nuxt.$route.name === 'sales-year-analysis' }">
      <i class="ti-bar-chart"></i>
      <p>分析</p>
    </sidebar-link>
    <sidebar-link to="/account">
      <i class="ti-user"></i>
      <p>アカウント設定</p>
    </sidebar-link>
  </side-bar>
</template>
