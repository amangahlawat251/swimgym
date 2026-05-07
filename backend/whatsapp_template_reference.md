# WhatsApp Template Reference

Use these exact templates in the dgasskyworld / WhatsApp template panel.

Important rules:
- Provider template names must be lowercase alphabetic only and maximum 15 characters.
- Do not start or end the template body with a variable.
- Use positional placeholders like `{{1}}`, `{{2}}`, `{{3}}`.
- Offers, discounts, promotions, campaigns, sales, and advertisements must be `MARKETING`, not `UTILITY`.
- After Meta/provider approval, click Sync Provider List / Sync Status in the Swim Gym tool.

---

## 1. Member Created

Provider template name:

```text
memberadded
```

Category:

```text
UTILITY
```

Template body:

```text
🎉 Welcome to Swim Gym Academy!

Hello {{1}}, your membership is now active.

🆔 Membership ID: {{2}}
🏊 Plan: {{3}}
📅 Start Date: {{4}}
⏳ Expiry Date: {{5}}
🕒 Timing: {{6}}

📩 Your invoice has been shared on your registered email address.

Thank you for choosing Swim Gym Academy. We look forward to being part of your fitness journey!
```

Placeholder mapping:

```text
{{1}} = Member name
{{2}} = Membership ID
{{3}} = Plan name
{{4}} = Start date
{{5}} = Expiry date
{{6}} = Timing
```

---

## 2. Membership Renewed

Provider template name:

```text
memberrenewed
```

Category:

```text
UTILITY
```

Template body:

```text
🎉 Your Swim Gym Academy membership has been renewed!

Hello {{1}}, your membership renewal has been completed successfully.

🆔 Membership ID: {{2}}
🏊 Plan: {{3}}
⏳ New Expiry Date: {{4}}

📩 Your renewal invoice has been shared on your registered email address.

Thank you for continuing with Swim Gym Academy. We’re excited to keep supporting your fitness journey!
```

Placeholder mapping:

```text
{{1}} = Member name
{{2}} = Membership ID
{{3}} = Plan name
{{4}} = New expiry date
```

---

## 3. Membership Freeze

Provider template name:

```text
memberfreeze
```

Category:

```text
UTILITY
```

Template body:

```text
⏸️ Your Swim Gym Academy membership has been frozen successfully.

Hello {{1}}, your membership freeze request has been confirmed.

🆔 Membership ID: {{2}}
📆 Freeze Duration: {{3}} days
⏳ Freeze Active Till: {{4}}
📅 Updated Expiry Date: {{5}}

Your membership access will automatically resume as per the freeze schedule.

Thank you for choosing Swim Gym Academy!
```

Placeholder mapping:

```text
{{1}} = Member name
{{2}} = Membership ID
{{3}} = Freeze duration in days
{{4}} = Freeze active till date
{{5}} = Updated expiry date
```

---

## 4. Expiring Today

Provider template name:

```text
expirytoday
```

Category:

```text
UTILITY
```

Template body:

```text
⏳ Your Swim Gym Academy membership expires today.

Hello {{1}}, this is a friendly reminder that your membership is expiring today.

🆔 Membership ID: {{2}}
🏊 Plan: {{3}}
📅 Expiry Date: {{4}}

Please renew your membership at the reception to continue enjoying uninterrupted access.

Thank you for being a part of Swim Gym Academy!
```

Placeholder mapping:

```text
{{1}} = Member name
{{2}} = Membership ID
{{3}} = Plan name
{{4}} = Expiry date
```

---

## 5. Diwali Greeting

Provider template name:

```text
diwaliwish
```

Category:

```text
UTILITY
```

If WhatsApp rejects it as Utility, recreate it as:

```text
MARKETING
```

Template body:

```text
🪔 Warm Diwali wishes from Swim Gym Academy!

Hello {{1}}, may this festival of lights bring happiness, good health, success, and bright new beginnings to you and your family.

Thank you for being a valued part of Swim Gym Academy.

Wishing you a joyful and prosperous Diwali!
```

Placeholder mapping:

```text
{{1}} = Member name
```

---

## 6. New Year Greeting

Provider template name:

```text
newyearwish
```

Category:

```text
UTILITY
```

If WhatsApp rejects it as Utility, recreate it as:

```text
MARKETING
```

Template body:

```text
🎉 Happy New Year from Swim Gym Academy!

Hello {{1}}, wishing you and your family a year filled with happiness, good health, success, and new achievements.

Thank you for being a valued part of Swim Gym Academy.

We look forward to supporting your fitness journey in the year ahead!
```

Placeholder mapping:

```text
{{1}} = Member name
```

---

## 7. Offer / Promotion

Provider template name example:

```text
specialoffer
```

Category:

```text
MARKETING
```

Template body:

```text
🎁 Special membership offer from Swim Gym Academy.

Hello {{1}}, we have a limited-time offer available for you.

📌 Offer Details: {{2}}
📅 Valid Till: {{3}}

Please contact reception for more information.
```

Placeholder mapping:

```text
{{1}} = Member name
{{2}} = Offer details
{{3}} = Offer valid till date
```

---

## Provider Name Mapping Used By The Tool

The tool automatically identifies system templates by these provider template names:

```text
memberadded    = member created message
memberrenewed  = membership renewal message
memberfreeze   = membership freeze message
expirytoday    = expiring today reminder
diwaliwish     = Diwali greeting
newyearwish    = New Year greeting
```

For any promotional or offer message, create it as a Marketing template. Once approved, select it from the WhatsApp panel and send it to Active, Inactive, All, or Selected users.
