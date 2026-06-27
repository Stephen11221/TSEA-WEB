@extends('layouts.app')
@section('title', 'Institutions - TSEA')

@section('content')
@php
    $institutions = $institution->institutions ?? [];
    $categories = collect($institutions)->pluck('category')->filter()->unique()->values();

    $institutionCount = max(1, count($institutions));
    $withLogoRate = round((collect($institutions)->filter(fn ($item) => !empty(trim((string) ($item['logo'] ?? ''))))->count() / $institutionCount) * 100, 1);
    $withCategoryRate = round((collect($institutions)->filter(fn ($item) => !empty(trim((string) ($item['category'] ?? ''))))->count() / $institutionCount) * 100, 1);
    $withLocationRate = round((collect($institutions)->filter(fn ($item) => !empty(trim((string) ($item['location'] ?? ''))))->count() / $institutionCount) * 100, 1);
    $withStudentDataRate = round((collect($institutions)->filter(fn ($item) => !empty(trim((string) ($item['students'] ?? ''))))->count() / $institutionCount) * 100, 1);

    $trendSource = collect($institution->trend_items ?? []);
    $trendMax = max(1, (float) ($trendSource->max() ?? 1));
    $trendPercentItems = $trendSource->mapWithKeys(function ($value, $label) use ($trendMax) {
        return [$label => round(((float) $value / $trendMax) * 100, 1)];
    })->toArray();
@endphp

<style>
    .institutions-directory {
        background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
        padding: clamp(2rem, 5vw, 3.8rem) 0 1.4rem;
    }

    .institutions-hero {
        position: relative;
        isolation: isolate;
        overflow: hidden;
        min-height: 660px;
        margin-bottom: clamp(2rem, 5vw, 3.4rem);
        padding: clamp(2.2rem, 5vw, 4.4rem);
        border: 1px solid rgba(29, 78, 216, .14);
        border-radius: 8px;
        background:
            radial-gradient(circle at 18% 18%, rgba(29, 78, 216, .16) 0 150px, transparent 151px),
            radial-gradient(circle at 82% 22%, rgba(251, 191, 36, .18) 0 110px, transparent 111px),
            radial-gradient(circle at 50% 90%, rgba(14, 165, 233, .16) 0 210px, transparent 211px),
            linear-gradient(135deg, #ffffff 0%, #f6faff 52%, #ffffff 100%);
        box-shadow: 0 28px 70px rgba(11, 31, 58, .09);
    }

    .institutions-hero::before {
        content: "";
        position: absolute;
        inset: 0;
        z-index: -2;
        opacity: .32;
        background-image:
            linear-gradient(rgba(29, 78, 216, .08) 1px, transparent 1px),
            linear-gradient(90deg, rgba(29, 78, 216, .08) 1px, transparent 1px),
            radial-gradient(ellipse at 23% 42%, transparent 0 52px, rgba(11, 31, 58, .1) 53px 54px, transparent 55px),
            radial-gradient(ellipse at 70% 54%, transparent 0 68px, rgba(11, 31, 58, .09) 69px 70px, transparent 71px),
            radial-gradient(ellipse at 48% 34%, transparent 0 118px, rgba(11, 31, 58, .08) 119px 120px, transparent 121px);
        background-size: 76px 76px, 76px 76px, 520px 280px, 620px 320px, 760px 360px;
        background-position: center;
    }

    .institutions-hero::after {
        content: "";
        position: absolute;
        inset: 0;
        z-index: -1;
        background:
            radial-gradient(circle at 15% 78%, rgba(29, 78, 216, .18) 0 3px, transparent 4px),
            radial-gradient(circle at 29% 28%, rgba(14, 165, 233, .2) 0 2px, transparent 3px),
            radial-gradient(circle at 67% 18%, rgba(251, 191, 36, .28) 0 2px, transparent 3px),
            radial-gradient(circle at 81% 69%, rgba(29, 78, 216, .18) 0 3px, transparent 4px),
            radial-gradient(circle at 53% 82%, rgba(14, 165, 233, .18) 0 2px, transparent 3px);
        animation: institutionParticles 11s linear infinite;
    }

    .institutions-hero-content {
        position: relative;
        z-index: 4;
        max-width: 790px;
        margin-inline: auto;
        text-align: center;
    }

    .institutions-hero-kicker {
        display: inline-flex;
        align-items: center;
        gap: .55rem;
        min-height: 34px;
        padding: .32rem .75rem;
        border: 1px solid rgba(29, 78, 216, .18);
        border-radius: 999px;
        background: rgba(255, 255, 255, .78);
        color: #1d4ed8;
        font-size: .74rem;
        font-weight: 900;
        text-transform: uppercase;
        box-shadow: 0 14px 36px rgba(29, 78, 216, .1);
        backdrop-filter: blur(14px);
    }

    .institutions-hero-kicker i {
        color: #e5a000;
    }

    .institutions-hero h1 {
        margin: 1rem 0 .85rem;
        color: #0b1f3a;
        font-size: clamp(2.45rem, 6vw, 5rem);
        line-height: 1.02;
        letter-spacing: 0;
    }

    .institutions-hero p {
        max-width: 760px;
        margin: 0 auto;
        color: #355070;
        font-size: clamp(1rem, 2vw, 1.24rem);
        line-height: 1.72;
    }

    .institutions-hero-actions {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        gap: .85rem;
        margin-top: 1.5rem;
    }

    .institutions-hero .btn {
        min-width: 190px;
        border-radius: 8px;
    }

    .institutions-hero .btn-secondary {
        border-color: rgba(29, 78, 216, .22);
        background: rgba(255, 255, 255, .86);
        box-shadow: 0 12px 30px rgba(15, 23, 42, .06);
    }

    .institutions-stats {
        position: relative;
        z-index: 4;
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: .8rem;
        max-width: 840px;
        margin: 2rem auto 0;
    }

    .institution-stat {
        min-height: 92px;
        padding: .95rem .8rem;
        border: 1px solid rgba(29, 78, 216, .14);
        border-radius: 8px;
        background: rgba(255, 255, 255, .76);
        box-shadow: 0 18px 46px rgba(11, 31, 58, .08);
        backdrop-filter: blur(16px);
        animation: statPulse 11s ease-in-out infinite;
    }

    .institution-stat:nth-child(2) { animation-delay: .7s; }
    .institution-stat:nth-child(3) { animation-delay: 1.4s; }
    .institution-stat:nth-child(4) { animation-delay: 2.1s; }

    .institution-stat strong {
        display: block;
        color: #0b1f3a;
        font-size: clamp(1.35rem, 2.4vw, 2rem);
        line-height: 1;
    }

    .institution-stat span {
        display: block;
        margin-top: .45rem;
        color: #52637a;
        font-size: .8rem;
        font-weight: 800;
    }

    .institutions-animation {
        position: absolute;
        inset: 0;
        z-index: 2;
        pointer-events: none;
    }

    .institution-glass-card {
        position: absolute;
        display: grid;
        align-content: center;
        gap: .35rem;
        width: 152px;
        min-height: 86px;
        padding: .85rem;
        border: 1px solid rgba(29, 78, 216, .18);
        border-radius: 8px;
        background: rgba(255, 255, 255, .68);
        box-shadow: 0 18px 50px rgba(11, 31, 58, .1);
        backdrop-filter: blur(18px);
        animation: institutionLightUp 11s ease-in-out infinite;
    }

    .institution-glass-card:nth-child(1) { left: 11%; top: 18%; animation-delay: .8s; }
    .institution-glass-card:nth-child(2) { left: 72%; top: 16%; animation-delay: 1.6s; }
    .institution-glass-card:nth-child(3) { left: 64%; top: 55%; animation-delay: 2.3s; }

    .institution-glass-card i {
        color: #1d4ed8;
        font-size: 1.15rem;
    }

    .institution-glass-card strong {
        color: #0b1f3a;
        font-size: .85rem;
        line-height: 1.2;
    }

    .institution-glass-card span {
        color: #64748b;
        font-size: .68rem;
        font-weight: 800;
        text-transform: uppercase;
    }

    .institution-network {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
    }

    .network-path {
        fill: none;
        stroke: #1d4ed8;
        stroke-width: 2;
        stroke-linecap: round;
        stroke-dasharray: 10 12;
        opacity: 0;
        filter: drop-shadow(0 0 8px rgba(29, 78, 216, .28));
        animation: networkFlow 11s ease-in-out infinite;
    }

    .network-path.gold {
        stroke: #e5a000;
        animation-delay: .7s;
    }

    .network-path.sky {
        stroke: #38bdf8;
        animation-delay: 1.3s;
    }

    .floating-icon {
        position: absolute;
        display: grid;
        place-items: center;
        width: 42px;
        height: 42px;
        border: 1px solid rgba(29, 78, 216, .14);
        border-radius: 8px;
        background: rgba(255, 255, 255, .78);
        color: #1d4ed8;
        box-shadow: 0 12px 32px rgba(11, 31, 58, .08);
        animation: floatIcon 7s ease-in-out infinite;
    }

    .floating-icon:nth-of-type(1) { left: 19%; bottom: 23%; animation-delay: .4s; }
    .floating-icon:nth-of-type(2) { left: 43%; top: 17%; color: #e5a000; animation-delay: 1.2s; }
    .floating-icon:nth-of-type(3) { right: 18%; bottom: 25%; animation-delay: 2s; }

    .student-stream {
        position: absolute;
        left: 0;
        bottom: 78px;
        display: flex;
        align-items: end;
        gap: .32rem;
        transform: translateX(-30%);
        animation: studentsWalk 11s ease-in-out infinite;
    }

    .student {
        position: relative;
        width: 38px;
        height: 92px;
        animation: studentStep .72s ease-in-out infinite;
    }

    .student:nth-child(2) { height: 102px; animation-delay: .16s; }
    .student:nth-child(3) { height: 88px; animation-delay: .32s; }
    .student:nth-child(4) { height: 98px; animation-delay: .48s; }

    .student::before {
        content: "";
        position: absolute;
        top: 0;
        left: 10px;
        width: 18px;
        height: 18px;
        border-radius: 50%;
        background: #b98968;
        box-shadow: 0 2px 0 rgba(11, 31, 58, .14);
    }

    .student:nth-child(2)::before { background: #6b3f2c; }
    .student:nth-child(3)::before { background: #d4a276; }
    .student:nth-child(4)::before { background: #8d5524; }

    .student::after {
        content: "";
        position: absolute;
        top: 21px;
        left: 6px;
        width: 26px;
        height: 42px;
        border-radius: 8px 8px 5px 5px;
        background: linear-gradient(180deg, #1d4ed8, #0b1f3a);
        box-shadow: -7px 8px 0 -2px #e5a000, 9px 6px 0 -4px #52637a;
    }

    .student:nth-child(2)::after { background: linear-gradient(180deg, #0b1f3a, #1e3a8a); box-shadow: -8px 9px 0 -2px #1d4ed8, 10px 7px 0 -4px #64748b; }
    .student:nth-child(3)::after { background: linear-gradient(180deg, #0ea5e9, #1d4ed8); box-shadow: -7px 8px 0 -2px #0b1f3a, 9px 7px 0 -4px #e5a000; }
    .student:nth-child(4)::after { background: linear-gradient(180deg, #e5a000, #b7791f); box-shadow: -8px 9px 0 -2px #0b1f3a, 10px 7px 0 -4px #1d4ed8; }

    .student .leg {
        position: absolute;
        bottom: 0;
        left: 10px;
        width: 7px;
        height: 32px;
        border-radius: 999px;
        background: #0b1f3a;
        transform-origin: top center;
        animation: legWalk .72s ease-in-out infinite;
    }

    .student .leg:last-child {
        left: 21px;
        animation-delay: .36s;
    }

    .passport-flow {
        position: absolute;
        left: 28%;
        bottom: 160px;
        width: 390px;
        height: 230px;
    }

    .digital-passport,
    .verified-profile {
        position: absolute;
        width: 142px;
        min-height: 88px;
        padding: .7rem;
        border: 1px solid rgba(29, 78, 216, .26);
        border-radius: 8px;
        background: rgba(255, 255, 255, .82);
        box-shadow: 0 0 0 1px rgba(255, 255, 255, .65) inset, 0 18px 42px rgba(29, 78, 216, .14);
        backdrop-filter: blur(16px);
    }

    .digital-passport {
        left: 0;
        bottom: 0;
        opacity: 0;
        transform: translateY(32px) scale(.8);
        animation: passportHologram 11s ease-in-out infinite;
    }

    .digital-passport:nth-child(2) {
        left: 118px;
        bottom: 54px;
        animation-delay: .4s;
    }

    .digital-passport:nth-child(3) {
        left: 236px;
        bottom: 4px;
        animation-delay: .8s;
    }

    .digital-passport::before {
        content: "";
        position: absolute;
        inset: 0;
        border-radius: inherit;
        background: linear-gradient(110deg, transparent 0 32%, rgba(56, 189, 248, .46) 42%, transparent 54%);
        transform: translateX(-120%);
        animation: scanLine 11s ease-in-out infinite;
    }

    .digital-passport strong,
    .verified-profile strong {
        display: flex;
        align-items: center;
        gap: .45rem;
        color: #0b1f3a;
        font-size: .78rem;
        line-height: 1.25;
    }

    .digital-passport strong i,
    .verified-profile strong i {
        color: #1d4ed8;
    }

    .skill-bar {
        display: block;
        height: 6px;
        margin-top: .7rem;
        border-radius: 999px;
        overflow: hidden;
        background: #dbeafe;
    }

    .skill-bar::after {
        content: "";
        display: block;
        width: 100%;
        height: 100%;
        border-radius: inherit;
        background: linear-gradient(90deg, #1d4ed8, #38bdf8, #e5a000);
        transform: translateX(-100%);
        animation: skillFill 11s ease-in-out infinite;
    }

    .verified-profile {
        right: 15%;
        bottom: 150px;
        opacity: 0;
        transform: translateX(-120px) scale(.88);
        animation: profileToEmployer 11s ease-in-out infinite;
    }

    .employer-hub {
        position: absolute;
        right: 7%;
        bottom: 92px;
        width: 175px;
        height: 170px;
    }

    .building {
        position: absolute;
        inset: auto 0 0 auto;
        width: 132px;
        height: 150px;
        border: 1px solid rgba(11, 31, 58, .16);
        border-radius: 8px 8px 4px 4px;
        background: linear-gradient(180deg, rgba(255, 255, 255, .92), rgba(219, 234, 254, .86));
        box-shadow: 0 18px 45px rgba(11, 31, 58, .12);
    }

    .building::before {
        content: "";
        position: absolute;
        left: 18px;
        right: 18px;
        top: 18px;
        height: 88px;
        background:
            linear-gradient(90deg, #1d4ed8 0 10px, transparent 10px 24px) 0 0 / 34px 22px,
            linear-gradient(90deg, rgba(29, 78, 216, .24) 0 10px, transparent 10px 24px) 0 11px / 34px 22px;
    }

    .building::after {
        content: "";
        position: absolute;
        left: 50%;
        bottom: 0;
        width: 30px;
        height: 42px;
        transform: translateX(-50%);
        border-radius: 6px 6px 0 0;
        background: #0b1f3a;
    }

    .success-badge {
        position: absolute;
        right: 88px;
        top: 12px;
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        min-height: 34px;
        padding: .42rem .65rem;
        border-radius: 999px;
        background: #0b1f3a;
        color: #ffffff;
        font-size: .74rem;
        font-weight: 900;
        box-shadow: 0 14px 30px rgba(11, 31, 58, .2);
        opacity: 0;
        transform: translateY(14px) scale(.88);
        animation: hiredBadge 11s ease-in-out infinite;
    }

    .success-badge i {
        color: #fbbf24;
    }

    .institutions-toolbar {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 1rem;
        margin-bottom: 1.6rem;
    }

    .institutions-heading h1 {
        color: #0b1d33;
        font-size: clamp(1.65rem, 3vw, 2rem);
        line-height: 1.15;
        margin: 0 0 .55rem;
        letter-spacing: 0;
    }

    .institutions-heading p {
        color: #64748b;
        margin: 0;
        font-size: .98rem;
    }

    .institution-filters {
        display: grid;
        grid-template-columns: minmax(240px, 360px) minmax(180px, 210px);
        gap: .9rem;
    }

    .institution-search,
    .institution-select {
        min-height: 48px;
        border: 1px solid #dbe3ef;
        border-radius: 8px;
        background: #ffffff;
        color: #0f172a;
        box-shadow: 0 10px 24px rgba(15, 23, 42, .04);
    }

    .institution-search {
        display: flex;
        align-items: center;
        gap: .7rem;
        padding: 0 .95rem;
    }

    .institution-search input,
    .institution-select {
        width: 100%;
        border: 0;
        outline: 0;
        font: inherit;
        color: inherit;
    }

    .institution-search input::placeholder {
        color: #64748b;
    }

    .institution-search i {
        color: #355070;
    }

    .institution-select {
        padding: 0 .95rem;
    }

    .institution-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 1.05rem;
    }

    .institution-card {
        min-height: 168px;
        display: grid;
        grid-template-columns: 86px minmax(0, 1fr);
        gap: 1.05rem;
        padding: 1.25rem;
        border: 1px solid #dfe7f2;
        border-radius: 8px;
        background: #ffffff;
        box-shadow: 0 14px 34px rgba(15, 23, 42, .06);
    }

    .institution-logo {
        width: 72px;
        height: 72px;
        display: grid;
        place-items: center;
        border-radius: 8px;
        overflow: hidden;
        color: #0b1d33;
        font-weight: 900;
        font-size: 1.2rem;
        background: linear-gradient(135deg, #e8f1ff, #f8fbff);
    }

    .institution-logo img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        padding: .55rem;
        background: #ffffff;
    }

    .institution-card[data-accent="green"] .institution-logo { background: linear-gradient(135deg, #dcfce7, #f0fdf4); color: #166534; }
    .institution-card[data-accent="purple"] .institution-logo { background: linear-gradient(135deg, #ede9fe, #faf5ff); color: #4c1d95; }
    .institution-card[data-accent="gold"] .institution-logo { background: linear-gradient(135deg, #ffedd5, #fff7ed); color: #9a3412; }
    .institution-card[data-accent="red"] .institution-logo { background: linear-gradient(135deg, #fee2e2, #fff1f2); color: #b91c1c; }

    .institution-card h2 {
        margin: 0 0 .45rem;
        color: #0b1d33;
        font-size: 1.02rem;
        line-height: 1.3;
        letter-spacing: 0;
    }

    .institution-badge {
        display: inline-flex;
        align-items: center;
        min-height: 24px;
        padding: .18rem .5rem;
        border: 1px solid #3b82f6;
        border-radius: 5px;
        color: #1d4ed8;
        background: #eff6ff;
        font-size: .72rem;
        font-weight: 800;
        margin-bottom: .7rem;
    }

    .institution-card[data-accent="green"] .institution-badge { border-color: #22c55e; color: #15803d; background: #f0fdf4; }
    .institution-card[data-accent="purple"] .institution-badge { border-color: #8b5cf6; color: #6d28d9; background: #f5f3ff; }
    .institution-card[data-accent="gold"] .institution-badge { border-color: #f97316; color: #c2410c; background: #fff7ed; }
    .institution-card[data-accent="red"] .institution-badge { border-color: #ef4444; color: #dc2626; background: #fef2f2; }

    .institution-card p {
        color: #52637a;
        font-size: .9rem;
        line-height: 1.55;
        margin: 0;
    }

    .institution-meta {
        grid-column: 1 / -1;
        display: flex;
        justify-content: space-between;
        gap: .8rem;
        margin-top: .15rem;
        padding-top: .9rem;
        border-top: 1px solid #edf2f7;
        color: #0f2744;
        font-size: .82rem;
        font-weight: 800;
    }

    .institution-meta span {
        display: inline-flex;
        align-items: center;
        gap: .45rem;
        min-width: 0;
    }

    .institution-empty {
        display: none;
        padding: 1.2rem;
        border: 1px dashed #cbd5e1;
        border-radius: 8px;
        color: #64748b;
        background: #ffffff;
    }

    @keyframes institutionParticles {
        0%, 100% { transform: translate3d(0, 0, 0); opacity: .85; }
        50% { transform: translate3d(0, -18px, 0); opacity: 1; }
    }

    @keyframes statPulse {
        0%, 100% { transform: translateY(0); border-color: rgba(29, 78, 216, .14); }
        42%, 60% { transform: translateY(-5px); border-color: rgba(29, 78, 216, .32); box-shadow: 0 22px 50px rgba(29, 78, 216, .12); }
    }

    @keyframes institutionLightUp {
        0%, 12% { opacity: .68; transform: translateY(0); box-shadow: 0 18px 50px rgba(11, 31, 58, .1); }
        18%, 74% { opacity: 1; transform: translateY(-8px); box-shadow: 0 0 0 1px rgba(29, 78, 216, .2), 0 24px 62px rgba(29, 78, 216, .2); }
        100% { opacity: .68; transform: translateY(0); }
    }

    @keyframes networkFlow {
        0%, 16% { opacity: 0; stroke-dashoffset: 80; }
        26%, 74% { opacity: .78; stroke-dashoffset: 0; }
        100% { opacity: 0; stroke-dashoffset: -80; }
    }

    @keyframes floatIcon {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-14px); }
    }

    @keyframes studentsWalk {
        0% { transform: translateX(-34%); opacity: 0; }
        8%, 18% { opacity: 1; }
        32%, 70% { transform: translateX(22%); opacity: 1; }
        88%, 100% { transform: translateX(38%); opacity: 0; }
    }

    @keyframes studentStep {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-3px); }
    }

    @keyframes legWalk {
        0%, 100% { transform: rotate(12deg); }
        50% { transform: rotate(-16deg); }
    }

    @keyframes passportHologram {
        0%, 20% { opacity: 0; transform: translateY(32px) scale(.8); filter: blur(2px); }
        32%, 67% { opacity: 1; transform: translateY(-22px) scale(1); filter: blur(0); }
        80%, 100% { opacity: 0; transform: translate(80px, -76px) scale(.82); filter: blur(1px); }
    }

    @keyframes scanLine {
        0%, 24% { transform: translateX(-120%); opacity: 0; }
        32%, 46% { transform: translateX(115%); opacity: 1; }
        54%, 100% { transform: translateX(115%); opacity: 0; }
    }

    @keyframes skillFill {
        0%, 30% { transform: translateX(-100%); }
        42%, 72% { transform: translateX(0); }
        100% { transform: translateX(100%); }
    }

    @keyframes profileToEmployer {
        0%, 50% { opacity: 0; transform: translateX(-120px) scale(.88); }
        62%, 78% { opacity: 1; transform: translateX(0) scale(1); }
        90%, 100% { opacity: 0; transform: translateX(58px) scale(.92); }
    }

    @keyframes hiredBadge {
        0%, 64% { opacity: 0; transform: translateY(14px) scale(.88); }
        74%, 90% { opacity: 1; transform: translateY(0) scale(1); }
        100% { opacity: 0; transform: translateY(-8px) scale(.95); }
    }

    @media (max-width: 1180px) {
        .institution-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }

        .institutions-hero {
            min-height: 700px;
        }

        .institution-glass-card:nth-child(1) { left: 5%; top: 19%; }
        .institution-glass-card:nth-child(2) { left: auto; right: 5%; top: 18%; }
        .institution-glass-card:nth-child(3) { left: auto; right: 8%; top: 60%; }

        .passport-flow {
            left: 22%;
            bottom: 165px;
            transform: scale(.9);
            transform-origin: left bottom;
        }

        .employer-hub {
            right: 4%;
        }
    }

    @media (max-width: 760px) {
        .institutions-directory {
            padding-top: 1rem;
        }

        .institutions-hero {
            min-height: 780px;
            padding: 1.35rem;
        }

        .institutions-hero-content {
            text-align: left;
        }

        .institutions-hero h1 {
            font-size: clamp(2.25rem, 12vw, 3.2rem);
        }

        .institutions-hero p {
            font-size: .98rem;
        }

        .institutions-hero-actions {
            justify-content: flex-start;
        }

        .institutions-hero .btn {
            width: 100%;
            min-width: 0;
        }

        .institutions-stats {
            grid-template-columns: repeat(2, minmax(0, 1fr));
            margin-top: 1.4rem;
        }

        .institution-stat {
            min-height: 84px;
        }

        .institution-glass-card {
            width: 128px;
            min-height: 76px;
            padding: .7rem;
        }

        .institution-glass-card:nth-child(1) { left: 5%; top: 48%; }
        .institution-glass-card:nth-child(2) { right: 4%; top: 48%; }
        .institution-glass-card:nth-child(3) { right: 5%; top: 68%; }

        .floating-icon {
            display: none;
        }

        .student-stream {
            bottom: 58px;
            transform: scale(.82) translateX(-38%);
        }

        .passport-flow {
            left: 8%;
            bottom: 135px;
            transform: scale(.66);
        }

        .verified-profile {
            right: 11%;
            bottom: 106px;
            transform: scale(.72);
        }

        .employer-hub {
            right: 2%;
            bottom: 44px;
            transform: scale(.74);
            transform-origin: right bottom;
        }

        .institutions-toolbar,
        .institution-meta {
            flex-direction: column;
        }

        .institution-filters,
        .institution-grid {
            grid-template-columns: 1fr;
        }

        .institution-card {
            grid-template-columns: 74px minmax(0, 1fr);
            padding: 1rem;
        }

        .institution-logo {
            width: 64px;
            height: 64px;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .institutions-hero *,
        .institutions-hero::after {
            animation-duration: .001ms !important;
            animation-iteration-count: 1 !important;
            scroll-behavior: auto !important;
        }

        .digital-passport,
        .verified-profile,
        .success-badge {
            opacity: 1;
            transform: none;
        }
    }
</style>

<section class="institutions-directory">
    <div class="container">
        <div class="institutions-hero" aria-label="Institutions to employment journey">
            <div class="institutions-animation" aria-hidden="true">
                <svg class="institution-network" viewBox="0 0 1180 660" preserveAspectRatio="none">
                    <path class="network-path" d="M150 175 C315 165 385 260 500 320 S700 390 850 165" />
                    <path class="network-path sky" d="M260 500 C395 390 465 410 570 345 S710 250 790 400" />
                    <path class="network-path gold" d="M500 335 C630 290 750 345 1008 505" />
                    <path class="network-path" d="M450 455 C620 520 770 455 1000 500" />
                </svg>

                <div class="institution-glass-card">
                    <i class="fas fa-building-columns"></i>
                    <strong>Universities</strong>
                    <span>Verified Programs</span>
                </div>
                <div class="institution-glass-card">
                    <i class="fas fa-graduation-cap"></i>
                    <strong>TVET Partners</strong>
                    <span>Skills Evidence</span>
                </div>
                <div class="institution-glass-card">
                    <i class="fas fa-certificate"></i>
                    <strong>Accredited Schools</strong>
                    <span>Career Pathways</span>
                </div>

                <span class="floating-icon"><i class="fas fa-book-open"></i></span>
                <span class="floating-icon"><i class="fas fa-laptop-code"></i></span>
                <span class="floating-icon"><i class="fas fa-award"></i></span>

                <div class="student-stream">
                    <span class="student"><span class="leg"></span><span class="leg"></span></span>
                    <span class="student"><span class="leg"></span><span class="leg"></span></span>
                    <span class="student"><span class="leg"></span><span class="leg"></span></span>
                    <span class="student"><span class="leg"></span><span class="leg"></span></span>
                </div>

                <div class="passport-flow">
                    <div class="digital-passport">
                        <strong><i class="fas fa-id-card"></i> Workforce Passport™</strong>
                        <span class="skill-bar"></span>
                    </div>
                    <div class="digital-passport">
                        <strong><i class="fas fa-fingerprint"></i> Verified Skills</strong>
                        <span class="skill-bar"></span>
                    </div>
                    <div class="digital-passport">
                        <strong><i class="fas fa-shield-halved"></i> Career Ready</strong>
                        <span class="skill-bar"></span>
                    </div>
                </div>

                <div class="verified-profile">
                    <strong><i class="fas fa-circle-check"></i> Verified Profile</strong>
                    <span class="skill-bar"></span>
                </div>

                <div class="employer-hub">
                    <div class="building"></div>
                    <div class="success-badge"><i class="fas fa-check-circle"></i> Hired</div>
                </div>
            </div>

            <div class="institutions-hero-content">
                <span class="institutions-hero-kicker"><i class="fas fa-bolt"></i> Verified education to work</span>
                <h1>Connecting Institutions to Employment</h1>
                <p>Empowering students with verified skills, digital Workforce Passports™, and direct pathways to employers.</p>
                <div class="institutions-hero-actions">
                    <a class="btn btn-primary" href="#institutionGrid">Explore Institutions</a>
                    <a class="btn btn-secondary" href="{{ route('passport.create') }}">Create Workforce Passport</a>
                </div>
            </div>

            <div class="institutions-stats" aria-label="Institution network statistics">
                <div class="institution-stat">
                    <strong>{{ $withLogoRate }}%</strong>
                    <span>Logo Coverage</span>
                </div>
                <div class="institution-stat">
                    <strong>{{ $withCategoryRate }}%</strong>
                    <span>Category Coverage</span>
                </div>
                <div class="institution-stat">
                    <strong>{{ $withLocationRate }}%</strong>
                    <span>Location Coverage</span>
                </div>
                <div class="institution-stat">
                    <strong>{{ $withStudentDataRate }}%</strong>
                    <span>Student Data Coverage</span>
                </div>
            </div>
        </div>

        <div class="institutions-toolbar">
            <div class="institutions-heading">
                <h1>{{ $institution->hero_label ?: 'Institutions' }}</h1>
                <p>{{ $institution->hero_description }}</p>
            </div>
            <div class="institution-filters">
                <label class="institution-search" for="institutionSearch">
                    <input id="institutionSearch" type="search" placeholder="Search institutions..." autocomplete="off">
                    <i class="fas fa-search" aria-hidden="true"></i>
                </label>
                <select id="institutionCategory" class="institution-select" aria-label="Filter institutions by category">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ strtolower($category) }}">{{ $category }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="institution-grid" id="institutionGrid">
            @foreach($institutions as $item)
                @php
                    $name = $item['name'] ?? '';
                    $words = collect(explode(' ', $name))->filter()->take(3);
                    $initials = $words->map(fn ($word) => strtoupper(substr($word, 0, 1)))->implode('');
                    $logo = trim($item['logo'] ?? '');
                @endphp
                <article
                    class="institution-card"
                    data-name="{{ strtolower($name) }}"
                    data-category="{{ strtolower($item['category'] ?? '') }}"
                    data-accent="{{ $item['accent'] ?? 'blue' }}"
                >
                    <div class="institution-logo" aria-hidden="true">
                        @if($logo !== '')
                            <img src="{{ asset($logo) }}" alt="">
                        @else
                            <span>{{ $initials }}</span>
                        @endif
                    </div>
                    <div>
                        <h2>{{ $name }}</h2>
                        <span class="institution-badge">{{ $item['category'] ?? 'Institution' }}</span>
                        <p>{{ $item['description'] ?? '' }}</p>
                    </div>
                    <div class="institution-meta">
                        <span><i class="fas fa-location-dot" aria-hidden="true"></i>{{ $item['location'] ?? '' }}</span>
                        <span><i class="fas fa-user-group" aria-hidden="true"></i>{{ $item['students'] ?? '' }}</span>
                    </div>
                </article>
            @endforeach
        </div>

        <div class="institution-empty" id="institutionEmpty">No institutions match your search.</div>
    </div>
</section>

<section class="section">
    <div class="container dashboard-grid">
        @foreach($institution->metrics ?? [] as $metric)
            @php
                $metricValue = trim((string) ($metric['value'] ?? ''));
                $metricValue = ($metricValue !== '' && is_numeric(str_replace(',', '', $metricValue)) && !str_contains($metricValue, '%')) ? ($metricValue . '%') : $metricValue;
            @endphp
            @include('partials.metric-card', ['value' => $metricValue, 'label' => $metric['label'] ?? ''])
        @endforeach

        <article class="card wide-card">
            <h2>{{ $institution->outcomes_title }}</h2>
            @include('partials.charts')
        </article>

        <article class="card">
            <h2>{{ $institution->trend_title }}</h2>
            @include('partials.charts', ['type' => 'bars', 'items' => $trendPercentItems])
        </article>

        <article class="card wide-card">
            <h2>{{ $institution->benefits_title }}</h2>
            <div class="grid three tight">
                @foreach($institution->benefits ?? [] as $benefit)
                    <div>{{ $benefit }}</div>
                @endforeach
            </div>
        </article>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const search = document.getElementById('institutionSearch');
        const category = document.getElementById('institutionCategory');
        const cards = Array.from(document.querySelectorAll('.institution-card'));
        const empty = document.getElementById('institutionEmpty');

        function filterInstitutions() {
            const query = search.value.trim().toLowerCase();
            const selectedCategory = category.value;
            let visibleCount = 0;

            cards.forEach((card) => {
                const matchesSearch = !query || card.dataset.name.includes(query);
                const matchesCategory = !selectedCategory || card.dataset.category === selectedCategory;
                const isVisible = matchesSearch && matchesCategory;

                card.style.display = isVisible ? '' : 'none';
                visibleCount += isVisible ? 1 : 0;
            });

            empty.style.display = visibleCount === 0 ? 'block' : 'none';
        }

        search.addEventListener('input', filterInstitutions);
        category.addEventListener('change', filterInstitutions);
    });
</script>
@endsection
