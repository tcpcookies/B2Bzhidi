# ZHIDI Tech B2B 独立站 UI 设计方案

## 一、10 家同行网站分析

### 1. ROSS Mixers (mixers.com) — 美国，1842年成立
- **字体**: Poppins (现代几何无衬线)
- **配色**: 白底 + 深蓝主色 + 橙色点缀
- **Hero**: 大标题 + 视频背景 + CTA按钮
- **布局**: 数据展示（年份/工厂/员工数）+ 产品视频 + 行业分类 + 资源中心
- **亮点**: 信任背书极强（1842年、ESOP员工持股），视频内容丰富

### 2. FlackTek (flacktek.com) — 美国，高速无叶片混合机
- **字体**: articulat-cf (定制现代字体)
- **配色**: 白底 + 深色 + 渐变蓝紫
- **Hero**: 动态文字轮播 + 产品图 + 视频
- **布局**: 技术优势 → 产品系列 → 客户案例 → 工程能力
- **亮点**: 动效设计极佳，hero 文字动态切换（R&D/quality/process...），科技感强

### 3. EIRICH (eirich.com) — 德国，强力混合机先驱
- **字体**: Manrope (现代无衬线)
- **配色**: 白底 + 深蓝 + 绿色点缀
- **Hero**: 大图背景 + 产品搜索器 + 行业入口
- **布局**: 产品搜索器 → 行业分类 → 新闻 → 展会
- **亮点**: "Productfinder" 交互工具，配置实验室搅拌机；行业图标网格清晰

### 4. Hockmeyer (hockmeyer.com) — 美国，湿法研磨分散
- **字体**: Barlow (现代工业风)
- **配色**: 白底 + 深蓝 + 橙色CTA
- **Hero**: 大标题 + 保证声明 + 设备图
- **布局**: 设备分类 → 技术支持 → 市场 → 博客
- **亮点**: "GUARANTEE" 保证营销，电话 CTA 突出，设备分类清晰

### 5. Silverson (silverson.com) — 英国，高剪切混合机
- **字体**: Roboto (经典无衬线)
- **配色**: 白底 + 深蓝 + 青色点缀
- **Hero**: 大标题 + 产品图 + 视频
- **布局**: 产品系列 → 应用案例 → 客户logo墙 → 技术文章
- **亮点**: 客户logo墙（信任背书），案例研究丰富，视频教程

### 6. MIXACO (mixaco.com) — 德国，工业混合器创新者
- **字体**: System UI (原生字体栈)
- **配色**: 白底 + 深蓝 + 橙色
- **Hero**: 大标题 + 动态文字（Powders/Liquids/Granulates...）+ CTA
- **布局**: 产品亮点 → 混合器类型 → 全球服务 → 测试中心
- **亮点**: Hero 动态切换物料类型，免费测试 mixer，全球服务网络

### 7. THINKY (thinkymixer.com) — 日本，行星离心搅拌机
- **字体**: Noto Sans JP (日文优化)
- **配色**: 白底 + 蓝色主色 + 红色点缀
- **Hero**: 产品图 + 新闻列表
- **布局**: 新闻 → 产品分类 → 技术介绍 → 案例 → 下载
- **亮点**: 技术内容深度好，资料下载丰富，应用案例详细

### 8. Bühler (buhlergroup.com) — 瑞士，食品/材料加工巨头
- **字体**: Roboto (多语言支持)
- **配色**: 白底 + 深灰 + 红色点缀
- **Hero**: 大图 + 新闻卡片 + 行业入口
- **布局**: 行业方案 → 全球网络 → 视频 → 新闻
- **亮点**: 多语言架构，行业方案页深度好，全球网络地图

### 9. Myers Mixers (myersmixers.com) — 美国，混合分散设备
- **字体**: Ubuntu (圆润现代)
- **配色**: 白底 + 蓝色 + 橙色
- **布局**: 产品系列 → 应用 → 关于 → 联系
- **亮点**: 简洁直接，产品分类清晰

### 10. NETZSCH (netzsch.com) — 德国，研磨分散分析
- **字体**: 企业定制字体
- **配色**: 白底 + 深蓝 + 绿色
- **布局**: 三大事业部 → 行业方案 → 新闻 → 全球
- **亮点**: 多事业部架构清晰，技术白皮书下载

---

## 二、共同设计模式总结

| 特征 | 采用率 | 说明 |
|------|--------|------|
| 白色背景 + 深色文字 | 10/10 | 工业B2B标配 |
| 蓝色/深蓝主色调 | 8/10 | 信任感、专业感 |
| 橙色/红色CTA点缀 | 7/10 | 引导行动 |
| Hero区视频背景 | 4/10 | 高端品牌标配 |
| 产品分类网格 | 10/10 | 核心导航方式 |
| 客户logo墙/案例 | 6/10 | 信任背书 |
| 数据展示（年份/数量） | 5/10 | 实力展示 |
| 行业应用入口 | 8/10 | 用户导向导航 |
| 现代无衬线字体 | 10/10 | Poppins/Manrope/Roboto |
| 动效/交互 | 5/10 | 高端品牌差异化 |
| 多语言支持 | 6/10 | 国际化标配 |

---

## 三、ZHIDI Tech UI 设计方案

### 设计定位
**"现代工业 + 技术信任"** — 既要体现中国制造的实力感，又要具备国际B2B的专业审美。

### 配色方案
```
主色:    #1a3a5c (深蓝，信任/专业)
辅色:    #f47920 (橙色，CTA/活力)
背景:    #ffffff (白)
浅灰:    #f5f7fa (区块分隔)
深灰:    #333333 (正文)
中灰:    #666666 (辅助文字)
成功绿:  #10b981 (认证/保障)
```

### 字体方案
```
标题: Poppins (Google Fonts, 600/700/800 weight)
正文: Inter (Google Fonts, 400/500/600 weight)
中文: Noto Sans SC (备选)
```

### 首页布局结构

```
1. NAVBAR (固定顶部)
   - Logo + 导航链接 + Get Quote CTA按钮
   - 滚动时缩小/阴影

2. HERO (首屏)
   - 全宽背景：工厂实拍图 + 深色半透明遮罩
   - 大标题："Your Trusted Partner for Industrial Mixing Solutions"
   - 副标题：核心卖点（73+产品 / 工厂审计 / 贸易保障）
   - 两个CTA：Explore Products / Request Quote
   - 信任徽章行：Gold Supplier · Factory Audited · Trade Assurance

3. TRUST BAR (信任条)
   - 4列数据：73+ Products / 7+ Years / 10+ Countries / 2 Production Lines
   - 图标 + 数字 + 说明

4. PRODUCT CATEGORIES (产品分类)
   - 6列网格，每列一个品类
   - 卡片：产品图 + 品类名 + 型号数 + 价格范围
   - 悬停效果：图片放大 + 阴影

5. CORE PRODUCT SHOWCASE (核心产品)
   - 左图右文布局
   - 行星离心真空搅拌机大图 + 5张缩略图
   - 规格参数表（简版）
   - 两个CTA：View Details / Get Quote

6. INDUSTRIES (应用行业)
   - 6列图标网格
   - 锂电池 / 陶瓷 / 胶粘剂 / 涂料 / 化妆品 / 实验室
   - 图标 + 行业名

7. WHY CHOOSE US (为什么选我们)
   - 3列：工厂审计 / 贸易保障 / 快速交付
   - 图标 + 标题 + 描述

8. CTA BANNER (行动号召)
   - 深蓝背景 + 白色文字
   - "Ready to Start Your Project?"
   - 两个按钮：Request Quote / WhatsApp

9. FOOTER (页脚)
   - 4列：品牌 / 产品 / 公司 / 联系
   - 社交媒体图标
   - 版权信息
```

### 产品详情页布局

```
1. 面包屑导航
2. 产品图库（左）+ 产品信息（右）
   - 主图 + 5张缩略图
   - 产品名 + 标签（Core Product）
   - 关键特性列表（勾选图标）
   - 价格范围
   - CTA按钮：Request Quote / WhatsApp
3. 技术规格表（全宽）
4. 工作原理（3步图解）
5. 应用行业（网格链接）
6. 相关产品
7. CTA Banner
```

### 关键交互

1. **Sticky Navbar**: 滚动时缩小，保持可见
2. **Smooth Scroll**: 锚点平滑滚动
3. **Fade-in Animation**: 滚动到视口时淡入（Intersection Observer）
4. **Image Gallery**: 缩略图点击切换主图
5. **Mobile Menu**: 汉堡菜单 + 滑入动画
6. **WhatsApp Float**: 右下角悬浮 WhatsApp 按钮
7. **Form Validation**: 前端表单验证 + 提交反馈

### 技术实现

- HTML5 语义化标签
- Tailwind CSS (CDN) + 自定义 CSS 变量
- 原生 JavaScript (无框架依赖)
- Lucide Icons (CDN)
- 响应式断点：Mobile (< 768px) / Tablet (768-1024px) / Desktop (> 1024px)

### 与当前网站的差异

| 模块 | 当前 | 建议 |
|------|------|------|
| Hero | 静态文字 | 工厂实拍图背景 + 信任徽章 |
| 产品卡片 | 5张 | 6张（增加 Double Planetary） |
| 信任条 | 统计数字 | 图标 + 数字 + 描述 |
| CTA | 分散 | 集中 + WhatsApp悬浮 |
| 动效 | 基础fade-in | 滚动触发 + 悬停效果 |
| 配色 | 深蓝+橙色 | 保持，微调对比度 |
| 字体 | Inter | Poppins(标题) + Inter(正文) |
