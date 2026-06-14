# DESIGN.md — ZHIDI Tech B2B Industrial Website

> **Design Philosophy**: Modern German Industrial + Asian Manufacturing Power — ROSS/FlackTek's trust-building meets THINKY/EIRICH's technical depth. Built for global B2B buyers who value quality, audit-ability, and rapid response.

---

## 1. Visual Theme & Atmosphere

**品牌设计哲学**: "Industrial confidence without intimidation." 将德国精密设备的视觉语言与亚洲制造的性价比优势融为一体。干净、坦率、数据驱动——每个像素都服务于建立信任和促成询盘。

**视觉基调**: 现代工业风（60%）+ 科技信任感（30%）+ 人本温暖（10%）

**核心视觉关键词**:
- Precision Engineered（精密制造）
- Factory Direct（工厂直供）
- Audit Confirmed（审计认证）
- Rapid Response（快速响应）

**质感倾向**: 纯扁平 + 微阴影（2px-8px depth cue），无毛玻璃，无过度gradient。产品图区域使用6px圆角卡片，信息区使用0圆角全宽条带。白色空间（white space）是核心设计资产，占比不低于40%。

---

## 2. Color Palette & Roles

### Primary Colors
```css
--color-primary:       #0d1b2a;     /* 深蓝黑 — 导航、标题、Hero背景 */
--color-primary-deep:  #070d14;     /* 最深色 — 页脚背景 */
--color-primary-mid:   #1b2838;     /* 中蓝 — 交替区块、Card:hover */
```

### Brand & Accent
```css
--color-accent:        #f15a24;     /* 工业橙 — 所有CTA、Active态、关键数字 */
--color-accent-light:  #ff7a47;     /* 浅橙 — hover状态 */
--color-accent-subtle: rgba(241,90,36,0.08); /* 超浅橙 — 图标背景 */
```

### Neutral / Gray Scale
```css
--color-bg:            #ffffff;     /* 主背景 */
--color-bg-alt:        #f6f8fa;     /* 交替区块背景 */
--color-text:          #0d1b2a;     /* 主文字 */
--color-text-light:    #5f6b7a;     /* 辅助文字 */
--color-text-muted:    #8b95a5;     /* 禁用/占位文字 */
--color-border:        #dfe3e8;     /* 边框 */
--color-border-light:  #eef1f5;     /* 浅边框 */
```

### Semantic Colors
```css
--color-success:       #0eba83;     /* 认证、保障 */
--color-warning:       #f59e0b;     /* 注意 */
--color-error:         #ef4444;     /* 错误 */
--color-info:          #3b82f6;     /* 信息 */
```

### Surface & Overlay
```css
--color-glass:         rgba(13,27,42,0.04);
--color-overlay:       rgba(13,27,42,0.6);
--color-overlay-light: rgba(13,27,42,0.03);
```

### Shadows
```css
--shadow-card:         0 1px 3px rgba(13,27,42,0.04), 0 1px 2px rgba(13,27,42,0.06);
--shadow-card-hover:   0 4px 16px rgba(13,27,42,0.08), 0 2px 4px rgba(13,27,42,0.04);
--shadow-elevated:     0 8px 32px rgba(13,27,42,0.1), 0 2px 8px rgba(13,27,42,0.06);
--shadow-button:       0 2px 8px rgba(241,90,36,0.25);
--shadow-button-hover: 0 4px 16px rgba(241,90,36,0.35);
```

---

## 3. Typography Rules

### Font Family
```css
--font-heading: 'Poppins', 'Inter', system-ui, -apple-system, sans-serif;
--font-body: 'Inter', 'Segoe UI', system-ui, -apple-system, sans-serif;
```

### Type Scale

| Level | Size | Weight | Line Height | Letter Spacing | Usage |
|-------|------|--------|-------------|----------------|-------|
| Display | 56px/3.5rem | 800 | 1.08 | -0.02em | Hero 主标题 |
| H1 | 40px/2.5rem | 700 | 1.15 | -0.015em | 页面大标题 |
| H2 | 30px/1.875rem | 700 | 1.2 | -0.01em | 区块标题 |
| H3 | 22px/1.375rem | 600 | 1.3 | 0 | Card标题 |
| H4 | 18px/1.125rem | 600 | 1.35 | 0 | 小标题 |
| Body L | 17px/1.063rem | 400 | 1.65 | 0 | 正文 |
| Body | 15px/0.938rem | 400 | 1.6 | 0 | 辅助正文 |
| Small | 13px/0.813rem | 500 | 1.5 | 0.02em | 标签、元数据 |
| Nano | 11px/0.688rem | 600 | 1.4 | 0.05em | 上标标签、徽章 |

**设计哲学**: Poppins 的几何感用于标题传递"精密"；Inter 的易读性用于长篇内容传递"可靠"。最小可读字重400，小字不低于13px。标题与正文之间至少保持14px间距。

---

## 4. Component Stylings

### Buttons

```css
/* Primary CTA — Industrial Orange */
.btn-primary {
  background: #f15a24;
  color: #ffffff;
  padding: 13px 28px;
  border-radius: 8px;
  font-size: 15px;
  font-weight: 600;
  font-family: 'Poppins', sans-serif;
  border: none;
  box-shadow: 0 2px 8px rgba(241,90,36,0.25);
  transition: all 0.2s ease;
}
.btn-primary:hover {
  background: #ff7a47;
  transform: translateY(-1px);
  box-shadow: 0 4px 16px rgba(241,90,36,0.35);
}

/* Secondary — Dark Outline */
.btn-secondary {
  background: transparent;
  color: #0d1b2a;
  padding: 13px 28px;
  border-radius: 8px;
  font-size: 15px;
  font-weight: 600;
  border: 1.5px solid #dfe3e8;
  transition: all 0.2s ease;
}
.btn-secondary:hover {
  border-color: #0d1b2a;
  background: rgba(13,27,42,0.02);
}

/* Outlined White (for dark backgrounds) */
.btn-outline {
  background: transparent;
  color: #ffffff;
  padding: 13px 28px;
  border-radius: 8px;
  border: 1.5px solid rgba(255,255,255,0.3);
  font-weight: 600;
}
.btn-outline:hover {
  border-color: #ffffff;
  background: rgba(255,255,255,0.1);
}
```

### Cards

```css
/* Product Card */
.card {
  background: #ffffff;
  border: 1px solid #eef1f5;
  border-radius: 10px;
  overflow: hidden;
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  box-shadow: 0 1px 3px rgba(13,27,42,0.04), 0 1px 2px rgba(13,27,42,0.06);
}
.card:hover {
  border-color: #dfe3e8;
  transform: translateY(-4px);
  box-shadow: 0 8px 32px rgba(13,27,42,0.1), 0 2px 8px rgba(13,27,42,0.06);
}
.card-img {
  aspect-ratio: 4/3;
  object-fit: cover;
  background: #f6f8fa;
}
.card-body {
  padding: 22px;
}
```

### Inputs

```css
.input {
  width: 100%;
  padding: 12px 16px;
  border: 1.5px solid #dfe3e8;
  border-radius: 8px;
  font-size: 15px;
  font-family: 'Inter', sans-serif;
  background: #ffffff;
  transition: border-color 0.2s, box-shadow 0.2s;
}
.input:focus {
  outline: none;
  border-color: #f15a24;
  box-shadow: 0 0 0 3px rgba(241,90,36,0.08);
}
.input::placeholder {
  color: #8b95a5;
}
```

### Navigation

```css
.navbar {
  height: 68px;
  background: rgba(255,255,255,0.98);
  backdrop-filter: blur(12px);
  border-bottom: 1px solid #eef1f5;
  transition: all 0.3s ease;
}
.navbar.scrolled {
  height: 56px;
  box-shadow: 0 1px 3px rgba(13,27,42,0.06);
}
.nav-link {
  font-size: 14.5px;
  font-weight: 500;
  color: #5f6b7a;
  transition: color 0.2s;
}
.nav-link:hover,
.nav-link.active {
  color: #0d1b2a;
}
.nav-link.active::after {
  content: '';
  display: block;
  height: 2px;
  background: #f15a24;
  margin-top: 2px;
}
```

### Badges / Tags

```css
.badge {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  padding: 5px 12px;
  border-radius: 100px;
  font-size: 13px;
  font-weight: 600;
}
.badge-accent {
  background: rgba(241,90,36,0.08);
  color: #f15a24;
}
.badge-success {
  background: rgba(14,186,131,0.08);
  color: #0eba83;
}
```

### Section Labels

```css
.section-label {
  display: inline-block;
  font-size: 11px;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 2.5px;
  color: #f15a24;
  margin-bottom: 14px;
}
```

---

## 5. Layout Principles

### Spacing System
- **基数**: 4px
- **常用倍数**: 8, 12, 16, 20, 24, 32, 40, 48, 56, 64, 80, 96, 120

### Grid System
- **列数**: 12列 (desktop), 8列 (tablet), 4列 (mobile)
- **间距**: 24px (column gap), 32px (row gap)
- **最大宽度**: 1280px (标准容器), 960px (窄容器), 1440px (宽容器)

### Container
```css
.container {
  max-width: 1280px;
  margin: 0 auto;
  padding: 0 28px;
}
.container-narrow {
  max-width: 960px;
}
```

### Section Spacing
```css
.section { padding: 88px 0; }        /* 标准区块 */
.section-sm { padding: 56px 0; }      /* 小间距区块 */
.section-lg { padding: 120px 0; }     /* 大间距区块 */
```

### 留白哲学
正文行之间无强制间距，但段落之间至少18px。区块标题到内容区至少32px。卡片内容padding不低于20px。不允许3个以上的全宽色块连续出现——每2个色块之间必须有白色留白区块。

---

## 6. Depth & Elevation

### Shadow System
```css
--shadow-none:          none;
--shadow-1:             0 1px 2px rgba(13,27,42,0.04);           /* subtle card */
--shadow-2:             0 1px 3px rgba(13,27,42,0.04), 0 1px 2px rgba(13,27,42,0.06);  /* card */
--shadow-3:             0 4px 16px rgba(13,27,42,0.08);          /* card:hover */
--shadow-4:             0 8px 32px rgba(13,27,42,0.1);           /* elevated */
--shadow-5:             0 12px 40px rgba(13,27,42,0.12);         /* modal */
--shadow-orange:        0 2px 8px rgba(241,90,36,0.25);          /* button */
--shadow-orange-hover:  0 4px 16px rgba(241,90,36,0.35);
```

### Surface Layers
| Layer | z-index | Usage |
|-------|---------|-------|
| background | 0 | 页面背景 |
| content | 1 | 普通内容 |
| dropdown | 100 | 下拉菜单 |
| sticky | 500 | 粘性导航 |
| overlay | 800 | 遮罩层 |
| modal | 1000 | 模态框 |
| toast | 1100 | 通知 |

### Backdrop Effects
```css
.navbar {
  backdrop-filter: blur(12px) saturate(180%);
  -webkit-backdrop-filter: blur(12px) saturate(180%);
}
```

---

## 7. Do's and Don'ts

### Do's ✅
1. **用数据说话** — 数字（73+ Products, 7+ Years）优先于形容词
2. **CTA 统一橙色** — 所有主行动按钮使用 `--color-accent`，不出现红色/绿色 CTA
3. **信任徽章前置** — Gold Supplier / Factory Audited / Trade Assurance 在 Hero 第一屏出现
4. **产品图优先** — 每个产品卡片必须有产品实拍图，不出现纯文字卡片
5. **间距充裕** — 图片和信息之间至少24px间距，卡片之间至少24px
6. **组件一致性** — 同类型元素使用相同圆角（全部8px）、相同阴影层级
7. **文字可读** — body文字不低于15px，行高不低于1.5，对比度不低于4.5:1
8. **动画克制** — 仅使用 translateY + opacity 过渡，时长不超过0.3s，不使用弹跳/旋转

### Don'ts ❌
1. **不要纯黑色文字** — 永远使用 `#0d1b2a`（深蓝黑）代替 `#000000`
2. **不要彩虹配色** — 颜色不超过主色+橙色+成功绿三个色相
3. **不要 box-shadow 泛滥** — 仅卡片:hover、CTA button、modal 使用阴影
4. **不要过度渐变** — 仅 Hero 背景使用深蓝渐变，其他地方用纯色
5. **不要文本孤岛** — 任何文字区块最少3行，避免1-2行的零散段落
6. **不要缩略图过小** — 产品缩略图最小72px，hero图片最小覆盖50%视口
7. **不要 loading spinner** — 纯静态站，不需要任何加载动画
8. **不要自动播放视频** — 视频需用户主动点击播放

---

## 8. Responsive Behavior

### Breakpoints
```css
/* Mobile S: 320px-480px */
/* Mobile: 480px-768px */
/* Tablet: 768px-1024px */
/* Desktop: 1024px-1280px */
/* Wide: 1280px+ */
```

### Touch Targets
- **最小触摸目标**: 44px × 44px（符合 WCAG 2.1 AA）
- **菜单项间距**: 移动端至少 16px

### 折叠策略
| 组件 | Desktop | Tablet | Mobile |
|------|---------|--------|--------|
| Product Grid | 3列 | 2列 | 1列 |
| Industry Grid | 6列 | 3列 | 2列 |
| Trust Bar | 4列 | 2列 | 1列 |
| Footer | 4列 | 2列 | 1列 |
| Core Showcase | 左右 | 上下 | 上下 |
| Contact | 左右 | 上下 | 上下 |
| Hero h1 | 56px | 40px | 28px |

### Font Scaling
- Desktop: 100%（基准16px）
- Tablet: 不缩放
- Mobile < 480px: Hero标题降为28px，H1降为24px，H2降为22px

---

## 9. Agent Prompt Guide

### Quick Reference for AI Agents
```
Project: ZHIDI Tech B2B Industrial Website
Framework: Static HTML + Tailwind CSS CDN + Vanilla JS
Icons: Lucide Icons (CDN)
Fonts: Poppins 700/800 + Inter 400/500/600 (Google Fonts)
Primary: #0d1b2a | Accent: #f15a24 | BG: #ffffff | Alt BG: #f6f8fa
Spacing base: 4px | Border radius: 8px
Max width: 1280px | Section padding: 88px
Card shadow: 0 1px 3px rgba(13,27,42,0.04)
```

### Component Generation Prompts

**Prompt: Product Card**
"Generate a product category card with: image(4:3 aspect ratio, covers), product name(H3, Poppins 600), short description(Body/15px, --color-text-light), model count + price range in accent color, and a 'View Details →' link in orange. On hover: card lifts 4px with elevation shadow, image scales 1.05x. Border color transitions from light gray to medium gray. No emojis."

**Prompt: Hero Section**
"Create a full-width hero section with: dark navy gradient background(#0d1b2a→#1b2838), centered white text, main heading at 56px Poppins 800 with orange highlight word, subtitle at 17px/1.7 line-height at 80% opacity, two CTA buttons side by side(orange primary + white outline), and three trust badges above the heading(Gold Supplier, Factory Audited, Trade Assurance). Beneath the hero but overlapped upward: a 4-column trust stats bar with icons, numbers, and labels in white cards."

**Prompt: Contact Form**
"Build a contact form with: two-column grid(desktop) stacking to single column(mobile). Fields: Full Name, Company, Email, Phone, Product Interest(select), Message(textarea, min 120px). Each field: label above(13px, 600 weight), input with 1.5px border, focus ring in accent color. Submit button: full-width accent orange. Include sidebar with: phone, email, WhatsApp link, address, and Alibaba store link with corresponding Lucide icons."

**Prompt: Footer**
"Create a 4-column footer: Brand col(Logo + tagline), Products col(5 links), Company col(4 links), Contact col(email + WhatsApp + Alibaba link). Background: #070d14. Text: #8b95a5 with hover to #f15a24. Below: copyright + social icons divider."

### Iteration Guide for AI Agents
1. 优先建立 CSS 变量系统，所有颜色通过 `var()` 引用
2. 每完成一个区块，检查与该区块相邻的前后区块是否有足够的视觉呼吸空间
3. 产品图必须使用 local path（`assets/images/products/`），不使用外部 URL
4. 响应式先做 mobile 检查：所有按钮至少 44px 高，文字不溢出
5. 导航固定在顶部，滚动时缩小（72px→56px），带阴影
6. WhatsApp 悬浮按钮右下角固定，绿色，带脉冲动画
7. Schema.org 结构化数据必须保留在每个 HTML 的 `<head>` 中
8. Canonical URL 和 Open Graph 标签必须正确指向 `zhiditech.com`
9. 每个页面使用相同的 `<nav>` 结构，通过 `class="active"` 标记当前页
10. 所有交互仅使用 CSS transition + vanilla JS，不引入 jQuery/React/Vue
