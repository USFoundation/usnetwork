<?php

if(!isset($_GET['start'])){
    die('will be up soon');
}

$list = '1. abandon 
2. abate 1 
3. abbreviate 1 
4. abdicate 1 
5. abduct 
6. abhor 2 
7. abide 1 
8. abolish 4
9. abort 
10. abound 
11. abridge 1 
12. abscond 
13. absolve 1 
14. absorb 
15. abstain 
16. abstract 
17. abuse 1 
18. accelerate 1 
19. accent 
20. accentuate 1 
21. accept 
22. access 4
23. accessorize 1 
24. acclaim 
25. acclimate 1 
26. acclimatize 1 
27. accommodate 1 
28. accompany 3 
29. accomplish 4
30. accord 
31. accost 
32. account 
33. accredit 
34. accrue 1 
35. acculturate 1 
36. accumulate 1 
37. accuse 1 
38. accustom 
39. acerbate 1 
40. ache 1 
41. achieve 1 
42. acidify 3 
43. acknowledge 1 
44. acquaint 
45. acquiesce 1 
46. acquire 1 
47. acquit 2 
48. act 
49. activate 1 
50. actualize 1 
51. adapt 
52. add 
53. address 4
54. adhere 1 
55. adjoin 
56. adjourn 
57. adjudicate 1 
58. adjust 
59. administer 
60. administrate 1 
61. admire 1 
62. admit 2 
63. admonish 4
64. adopt 
65. adore 1 
66. adorn 
67. adsorb 
68. adulate 1 
69. advance 1 
70. advertise 1 
71. advise 1 
72. advocate 1 
73. affect 
74. affiliate 1 
75. affirm 
76. affix 4
77. afflict 
78. afford 
79. affront 
80. age 1 
81. aggravate 1 
82. aggregate 1 
83. aggrieve 1 
84. agitate 1 
85. agonize 1 
86. agree 1 RB 
87. aid 
88. ail 
89. aim 
90. airbrush 4
91. airdrop 2 
92. airlift 
93. airmail 
94. alarm 
95. alert 
96. alienate 1 
97. align 
98. allege 1 
99. alleviate 1 
100. allocate 1 
101. allot 2 
102. allow 
103. allude 1 
104. allure 1 
105. ally 3 
106. alphabetize 1 
107. alter 
108. alternate 1 
109. amalgamate 1 
110. amass 4
111. amaze 1 
112. ambush 4
113. amend 
114. amount 
115. amplify 3 
116. amputate 1 
117. amuse 1 
118. analogize 1 
119. analyze 1 
120. anchor 
121. anesthetize 1 
122. anger 
123. anguish 4
124. animate 1 
125. annex 4
126. annihilate 1 
127. annotate 1 
128. announce 1 
129. annoy 
130. annualize 1 
131. annul 2 
132. annunciate 1 
133. anoint 
134. answer 
135. antagonize 1 
136. anticipate 1 
137. antiquate 1 
138. apologize 1 
139. appall 
140. appeal 
141. appear LV
142. appease 1 
143. appertain 
144. applaud 
145. apply 3 
146. appoint 
147. appraise 1 
148. appreciate 1 
149. apprehend 
150. apprentice 1 
151. apprise 1 
152. approach 4
153. appropriate 1 
154. approve 1 
155. approximate 1 
156. arbitrage 1 
157. arbitrate 1 
158. archive 1 
159. argue 1 
160. arise 1 + 
161. arm 
162. armor 
163. aromatize 1 
164. arouse 1 
165. arraign 
166. arrange 1 
167. arrest 
168. arrive 1 
169. articulate 1 
170. ascend 
171. ascertain 
172. ascribe 1 
173. ask 
174. aspirate 1 
175. aspire 1 
176. assail 
177. assassinate 1 
178. assault 
179. assay 
180. assemble 1 
181. assent 
182. assert 
183. assess 4
184. assign 
185. assimilate 1 
186. assist 
187. associate 1 
188. assort 
189. assume 1 
190. assure 1 
191. astonish 4
192. astound 
193. atone 1 
194. attach 4
195. attack 
196. attain 
197. attempt 
198. attend 
199. attest 
200. attract 
201. attribute 1 
202. auction 
203. audit 
204. audition 
205. augment 
206. authenticate 1 
207. author 
208. authorize 1 
209. autograph 
210. automate 1 
211. avail 
212. avalanche 1 
213. avenge 1 
214. average 1 
215. avert 
216. aviate 1 
217. avoid 
218. avow 
219. await 
220. awake 1 + 
221. awaken 
222. award 
223. ax 4
224. babble 1 
225. baby 3 
226. back 
227. backdate 1 
228. backfire 1 
229. backhand 
230. backpack 
231. backpedal 
232. backspace 1 
233. backtrack 
234. backwash 4
235. badger 
236. badmouth 
237. baffle 1 
238. bag 2 
239. bail 
240. bait 
241. bake 1 
242. balance 1 
243. bale 1 
244. balk 
245. balloon 
246. ballyhoo 4
247. bamboozle 1 
248. ban 2 
249. band 
250. bandage 1 
251. bang 
252. banish 4
253. bank 
254. bankroll 
255. bankrupt 
256. banter 
257. baptize 1 
258. bar 2 
259. barbarize 1 
260. barbecue 1
261. bare 1 
262. bargain 
263. barge 1 
264. bark 
265. barnstorm 
266. barrage 1 
267. barricade 1 
268. barter 
269. base 1 
270. bash 4
271. bask 
272. baste 1 
273. bat 2 
274. batch 4
275. bath 
276. batter 
277. battle 1 
278. bawl 
279. be + LV 
280. beach 4
281. beam
282. bear + 
283. beat + 
284. beautify 3 
285. beckon 
286. become 1 + LV 
287. bedazzle 1 
288. beep 
289. befriend 
290. befuddle 1 
291. beg 2 
292. begin 2 + 
293. begrudge 1 
294. beguile 1 
295. behave 1 
296. behold + 
297. behoove 1 
298. belabor 
299. belch 4
300. beleaguer 
301. believe 1 
302. belittle 1 
303. bellow 
304. belong 
305. belt 
306. bemoan 
307. bemuse 1 
308. bend + 
309. benefit 
310. bequeath 
311. berate 1 
312. bereave 1 
313. beset 2 + 
314. besiege 1 
315. bestow 
316. bet 2 + 
317. betray 
318. better 
319. bewilder 
320. bewitch 4
321. bid + 
322. bide 
323. bill 
324. billow 
325. bind + 
326. bite 1 + 
327. blab 2 
328. blacken 
329. blacklist 
330. blame 1 
331. blast 
332. blaze 1 
333. bleach 4
334. bleed + 
335. blend 
336. bless 4
337. blind 
338. blindfold 
339. blink 
340. blister 
341. bloat 
342. block 
343. bloody 3 
344. bloom 
345. blossom 
346. blot 2 
347. blow + 
348. blunder 
349. blur 2 
350. blurt 
351. blush 4
352. board 
353. boast 
354. bob 2 
355. boil 
356. bolster 
357. bolt 
358. bomb 
359. bombard 
360. bond 
361. book 
362. boom 
363. boost 
364. boot 
365. border 
366. bore 1 
367. borrow 
368. bother 
369. bottle 1 
370. bounce 1 
371. bound 
372. bow 
373. bowl 
374. box 4
375. boycott 
376. brace 1 
377. brag 2 
378. braid 
379. brake 1 
380. branch 4
381. brand 
382. brave 1 
383. breach 4
384. break + 
385. breakfast 
386. breath 
387. breed + 
388. brew 
389. bribe 1 
390. bridge 1 
391. brief 
392. brighten 
393. bring + 
394. bristle 1 
395. broach 4
396. broadcast + 
397. broaden 
398. bronze 1 
399. brood 
400. bruise 1 
401. brush 4
402. bubble 1 
403. buck 
404. buckle 1 
405. budget 
406. buffer 
407. bug 2 
408. build + 
409. bulge 1 
410. bully 3 
411. bump 
412. bunch 4
413. bundle 1 
414. burden 
415. burgle 1 
416. burn +
417. burp 
418. burrow 
419. burst + 
420. bury 3
421. bus 4 RB
422. bust 
423. bustle 1 
424. busy 3 
425. butcher 
426. butter 
427. button 
428. buttress 4
429. buy + 
430. buzz 4
431. bypass 4
432. cackle 1 
433. cage 1 
434. cajole 1 
435. cake 1 
436. calculate 1 
437. calibrate 1 
438. call 
439. calm 
440. camouflage 1 
441. camp 
442. campaign 
443. can 2 
444. cancel RB 
445. canvass 4
446. cap 2 
447. capitalize 1 
448. capitulate 1 
449. capsize 1 
450. captain 
451. captivate 1 
452. capture 1 
453. care 1 
454. caress 4
455. carpet 
456. carry 3 
457. cart 
458. carve 1 
459. cascade 1 
460. cash 4
461. cast + 
462. castigate 1 
463. catalog RB 
464. catapult 
465. catch 4 + 
466. categorize 1 
467. cater 
468. cause 1 
469. caution 
470. cave 1 
471. cease 1 
472. celebrate 1 
473. cement 
474. censor 
475. censure 1 
476. center 
477. centralize 1 
478. certify 3 
479. chain 
480. chair 
481. challenge 1 
482. champion 
483. chance 1 
484. change 1 
485. channel 
486. chant 
487. char 2 
488. characterize 1 
489. charge 1 
490. charm 
491. chart 
492. charter 
493. chase 1 
494. chasten 
495. chat 2 
496. chatter 
497. cheat 
498. check 
499. cheer 
500. cherish 4
501. chew 
502. chide 1 
503. chill 
504. chime 1 
505. chip 2 
506. chirp 
507. choke 1 
508. choose 1 + 
509. chop 2 
510. choreograph 
511. christen 
512. chronicle 1 
513. chuck 
514. chuckle 1 
515. churn 
516. circle 1 
517. circulate 1 
518. circumscribe 1 
519. circumvent 
520. cite 1 
521. civilize 1 
522. claim 
523. clamber 
524. clamp 
525. clap 2 
526. clarify 3 
527. clash 4
528. clasp 
529. classify 3 
530. clatter 
531. claw 
532. clean 
533. cleanse 1 
534. clear 
535. clench 4
536. click 
537. climb 
538. clinch 4
539. cling + 
540. clip 2 
541. cloak 
542. clock 
543. clog 2 
544. clone 1 
545. close 1 
546. cloth 
547. cloud 
548. club 2 
549. cluster 
550. clutch 4
551. clutter 
552. coach 4
553. coat 
554. coax 4
555. cobble 1 
556. cock 
557. code 1 
558. codify 3 
559. coerce 1 
560. coil 
561. coin 
562. coincide 1 
563. collaborate 1 
564. collapse 1 
565. collate 1 
566. collect 
567. collide 1 
568. colonize 1 
569. color 
570. comb 
571. combine 1 
572. come 1 + 
573. comfort 
574. command 
575. commandeer 
576. commemorate 1 
577. commence 1 
578. commend 
579. comment 
580. commission 
581. commit 2 
582. communicate 1 
583. commute 1 
584. compact 
585. compare 1 
586. compel 2 
587. compensate 1 
588. compete 1 
589. compile 1 
590. complain 
591. complement 
592. complete 1 
593. complicate 1 
594. compliment 
595. comply 3 
596. compose 1 
597. compound 
598. comprehend 
599. compress 4
600. comprise 1 
601. compromise 1 
602. compute 1 
603. computerize 1 
604. con 2 
605. conceal 
606. concede 1 
607. conceive 1 
608. concentrate 1 
609. conceptualize 1 
610. concern 
611. concert 
612. conclude 1 
613. concoct 
614. concur 2 
615. condemn 
616. condense 1 
617. condition 
618. condone 1 
619. conduct 
620. confer 2 
621. confess 4
622. confide 1 
623. configure 1 
624. confine 1 
625. confirm 
626. confiscate 1 
627. conflict 
628. conform 
629. confound 
630. confront 
631. confuse 1 
632. congratulate 1 
633. congregate 1 
634. conjure 1 
635. connect 
636. conquer 
637. consecrate 1 
638. consent 
639. conserve 1 
640. consider 
641. consign 
642. consist 
643. console 1 
644. consolidate 1 
645. conspire 1 
646. constitute 1 
647. constrain 
648. constrict 
649. construct 
650. construe 1 
651. consult 
652. consume 1 
653. contact 
654. contain 
655. contaminate 1 
656. contemplate 1 
657. contend 
658. content 
659. contest 
660. continue 1 
661. contort 
662. contract 
663. contradict 
664. contrast 
665. contravene 1 
666. contribute 1 
667. contrive 1 
668. control 2 
669. convene 1 
670. converge 1 
671. converse 1 
672. convert 
673. convey 
674. convict 
675. convince 1 
676. cook 
677. cool 
678. cooperate 1 
679. coordinate 1 
680. cope 1 
681. copy 3 
682. copyright 
683. corner 
684. correct 
685. correlate 1 
686. correspond 
687. corroborate 1 
688. corrupt 
689. cost + 
690. couch 4
691. cough 
692. counsel 
693. count 
694. counter 
695. counterbalance 1 
696. court 
697. cover 
698. covet 
699. crack 
700. crackle 1 
701. cradle 1 
702. craft 
703. cram 2 
704. cramp 
705. crane 1 
706. crash 4
707. crave 1 
708. crawl 
709. creak 
710. crease 1 
711. create 1 
712. credit 
713. creep + 
714. cremate 1 
715. crest 
716. cringe 1 
717. cripple 1 
718. criticize 1 
719. critique 1 
720. croak 
721. crop 2 
722. cross 4
723. cross-examine 1 
724. crouch 4
725. crow 
726. crowd 
727. crown 
728. cruise 1 
729. crumble 1 
730. crumple 1 
731. crunch 4
732. crush 4
733. cry 3 
734. crystallize 1 
735. cuddle 1 
736. cull 
737. culminate 1 
738. cultivate 1 
739. cup 2 
740. curb 
741. cure 1 
742. curl 
743. curse 1 
744. curtail 
745. curve 1 
746. cushion 
747. customize 1 
748. cut 2 + 
749. cycle 1 
750. dab 2 
751. dabble 1 
752. damage 1 
753. dampen 
754. dance 1 
755. dangle 1 
756. dare 1 
757. darken 
758. dart 
759. dash 4
760. date 1 
761. dawn 
762. daze 1 
763. dazzle 1 
764. deadlock 
765. deal + 
766. debate 1 
767. debit 
768. decay 
769. deceive 1 
770. decentralize 1 
771. decide 1 
772. decimate 1 
773. decipher 
774. deck 
775. declare 1 
776. decline 1 
777. decompose 1 
778. decorate 1 
779. decrease 1 
780. decree 1 RB 
781. dedicate 1 
782. deduce 1 
783. deduct 
784. deed 
785. deem 
786. deepen 
787. deface 1 
788. default 
789. defeat 
790. defect 
791. defend 
792. defer 2 
793. define 1 
794. deflate 1 
795. deflect 
796. deform 
797. defray 
798. defuse 1 
799. defy 3 
800. degenerate 1 
801. degrade 1 
802. dehydrate 1 
803. delay 
804. delegate 1 
805. delete 1 
806. delight 
807. delineate 1 
808. deliver 
809. delude 1 
810. delve 1 
811. demand 
812. demolish 4
813. demonstrate 1 
814. demote 1 
815. denominate 1 
816. denote 1 
817. denounce 1 
818. dent 
819. deny 3 
820. depart 
821. depend 
822. depict 
823. deplete 1 
824. deplore 1 
825. deploy 
826. deport 
827. depose 1 
828. deposit 
829. deprecate 1 
830. depress 4
831. deprive 1 
832. deride 1 
833. derive 1 
834. descend 
835. describe 1 
836. desert 
837. deserve 1 
838. design 
839. designate 1 
840. desire 1 
841. despair 
842. despise 1 
843. destroy 
844. detach 4
845. detail 
846. detain 
847. detect 
848. deter 2 
849. deteriorate 1 
850. determine 1 
851. detest 
852. detonate 1 
853. devalue 1 
854. devastate 1 
855. develop 
856. deviate 1 
857. devise 1 
858. devolve 1 
859. devote 1 
860. devour 
861. diagnose 1 
862. dial 
863. dice 1 
864. dictate 1 
865. die 1 RB 
866. differ 
867. differentiate 1 
868. diffuse 1 
869. dig 2 + 
870. digest 
871. dignify 3 
872. dilapidate 1 
873. dilate 1 
874. dilute 1 
875. dim 2 
876. diminish 4
877. dine 1 
878. dip 2 
879. direct 
880. disable 1 
881. disadvantage 1 
882. disagree 1 RB 
883. disallow 
884. disappear 
885. disappoint 
886. disapprove 1 
887. disarm 
888. disband 
889. discard 
890. discern 
891. discharge 1 
892. discipline 1 
893. disclose 1 
894. disconcert 
895. disconnect 
896. discontinue 1 
897. discount 
898. discourage 1 
899. discover 
900. discredit 
901. discriminate 1 
902. discuss 4
903. disembark 
904. disfigure 1 
905. disgrace 1 
906. disgruntle 1 
907. disguise 1 
908. disgust 
909. dishevel 
910. dishonor 
911. disillusion 
912. disintegrate 1 
913. disinterest 
914. dislike 1 
915. dislocate 1 
916. dislodge 1 
917. dismantle 1 
918. dismay 
919. dismiss 4
920. dismount 
921. disorder 
922. disorientate 1 
923. disown 
924. dispatch 4
925. dispel 2 
926. dispense 1 
927. disperse 1 
928. displace 1 
929. display 
930. displease 1 
931. dispose 1 
932. dispossess 4
933. disprove 1 
934. dispute 1 
935. disqualify 3 
936. disregard 
937. disrespect 
938. disrupt 
939. dissatisfy 3 
940. dissect 
941. disseminate 1 
942. dissipate 1 
943. dissolve 1 
944. dissuade 1 
945. distain 
946. distance 1 
947. distill 
948. distinguish 4
949. distort 
950. distract 
951. distress 4
952. distribute 1 
953. distrust 
954. disturb 
955. ditch 4
956. dive 1 + 
957. diverge 1 
958. diversify 3 
959. divert 
960. divest 
961. divide 1 
962. divorce 1 
963. divulge 1 
964. do 4 + 
965. dock 
966. document 
967. dodge 1 
968. dog 2 
969. domesticate 1 
970. dominate 1 
971. don 2 
972. donate 1 
973. doom 
974. dot 2
975. dote 1 
976. double 1 
977. doubt 
978. douse 1 
979. down 
980. downgrade 1 
981. download 
982. doze 1 
983. draft 
984. drag 2 
985. drain 
986. dramatize 1 
987. drape 1 
988. draw + 
989. drawl 
990. dread 
991. dream + 
992. dredge 1 
993. drench 4
994. dress 4
995. dribble 1 
996. drift 
997. drill 
998. drink + 
999. drip 2 
1000. drive 1 + 
1001. drone 1 
1002. droop 
1003. drop 2 
1004. drown 
1005. drum 2 
1006. dry 3 
1007. dub 2 
1008. duck 
1009. dull 
1010. dump 
1011. dupe 1 
1012. duplicate 1 
1013. dust 
1014. dwarf 
1015. dwell 
1016. dwindle 1 
1017. dye 1 
1018. earn 
1019. ease 1 
1020. eat + 
1021. ebb 
1022. echo 4
1023. eclipse 1 
1024. edge 1 
1025. edit 
1026. educate 1 
1027. efface 1 
1028. effect 
1029. eject 
1030. elaborate 1 
1031. elapse 1 
1032. elate 1 
1033. elbow 
1034. elect 
1035. electrify 3 
1036. elevate 1 
1037. elicit 
1038. eliminate 1 
1039. elongate 1 
1040. elude 1 
1041. emaciate 1 
1042. emanate 1 
1043. embark 
1044. embarrass 4
1045. embed 2 
1046. embellish 4
1047. embody 3 
1048. embolden 
1049. emboss 4
1050. embrace 1 
1051. embroider 
1052. emend 
1053. emerge 1 
1054. emigrate 1 
1055. emit 2 
1056. emphasize 1 
1057. employ 
1058. empower 
1059. empty 3 
1060. emulate 1 
1061. enable 1 
1062. enact 
1063. encapsulate 1 
1064. encase 1 
1065. enchant 
1066. enclose 1 
1067. encode 1 
1068. encompass 4
1069. encounter 
1070. encourage 1 
1071. encroach 4
1072. end 
1073. endanger 
1074. endear 
1075. endeavor 
1076. endorse 1 
1077. endow 
1078. endure 1 
1079. enforce 1 
1080. engage 1 
1081. engender 
1082. engineer 
1083. engrave 1 
1084. engross 4
1085. engulf 
1086. enhance 1 
1087. enjoy 
1088. enlarge 1 
1089. enlighten 
1090. enlist 
1091. enliven 
1092. enmesh 4
1093. enquire 1 
1094. enrage 1 
1095. enrich 4
1096. enroll 
1097. enshrine 1 
1098. ensnare 1 
1099. ensue 1 
1100. ensure 1 
1101. entail 
1102. entangle 1 
1103. enter 
1104. entertain 
1105. entice 1 
1106. entitle 1 
1107. entrench 4
1108. entrust 
1109. enumerate 1 
1110. enunciate 1 
1111. envelop 
1112. envy 3 
1113. epitomize 1 
1114. equal 
1115. equalize 1 
1116. equate 1 
1117. equip 2 
1118. eradicate 1 
1119. erase 1 
1120. erect 
1121. erode 1 
1122. err 
1123. erupt 
1124. escalate 1 
1125. escape 1 
1126. eschew 
1127. escort 
1128. espouse 1 
1129. establish 4
1130. esteem 
1131. estimate 1 
1132. estrange 1 
1133. etch 4
1134. evacuate 1 
1135. evade 1 
1136. evaluate 1 
1137. evaporate 1 
1138. evict 
1139. evidence 1 
1140. evince 1 
1141. evoke 1 
1142. evolve 1 
1143. exacerbate 1 
1144. exact 
1145. exaggerate 1 
1146. exalt 
1147. examine 1 
1148. exasperate 1 
1149. excavate 1 
1150. exceed 
1151. excel 2 
1152. exchange 1 
1153. excise 1 
1154. excite 1 
1155. exclaim 
1156. exclude 1 
1157. excrete 1 
1158. excuse 1 
1159. execute 1 
1160. exemplify 3 
1161. exempt 
1162. exercise 1 
1163. exert 
1164. exhale 1 
1165. exhaust 
1166. exhibit 
1167. exhilarate 1 
1168. exhort 
1169. exile 1 
1170. exist 
1171. exit 
1172. expand 
1173. expect 
1174. expedite 1 
1175. expel 2 
1176. expend 
1177. experience 1 
1178. experiment 
1179. expire 1 
1180. explain 
1181. explode 1 
1182. exploit 
1183. explore 1 
1184. export 
1185. expose 1 
1186. expound 
1187. express 4
1188. extend 
1189. extinguish 4
1190. extract 
1191. extradite 1 
1192. eye 1 
1193. fabricate 1 
1194. face 1 
1195. facilitate 1 
1196. factor 
1197. fade 1 
1198. fail 
1199. faint 
1200. fake 1 
1201. fall + 
1202. falsify 3 
1203. falter 
1204. fan 2 
1205. fancy 3 
1206. fare 1 
1207. farm 
1208. fascinate 1 
1209. fashion 
1210. fasten 
1211. fathom 
1212. fatigue 1 
1213. fault 
1214. favor 
1215. fax 4
1216. fear 
1217. feather 
1218. feature 1 
1219. federate 1 
1220. feed + 
1221. feel + LV
1222. feign 
1223. fell 
1224. fence 1 
1225. ferment 
1226. ferry 3 
1227. fertilize 1 
1228. fetch 4
1229. fiddle 1 
1230. fidget 
1231. field 
1232. fight + 
1233. figure 1 
1234. file 1 
1235. fill 
1236. film 
1237. filter 
1238. finalize 1 
1239. finance 1 
1240. find + 
1241. fine 1 
1242. finger 
1243. finish 4
1244. fire 1 
1245. firm 
1246. fish 4
1247. fit 2 + 
1248. fix 4
1249. flag 2 
1250. flame 
1251. flank 
1252. flap 2 
1253. flare 1 
1254. flash 4
1255. flatten 
1256. flatter 
1257. flaunt 
1258. flavor 
1259. flaw 
1260. flee 1 RB + 
1261. flex 4
1262. flick 
1263. flicker 
1264. flinch 4
1265. fling + 
1266. flip 2 
1267. flirt 
1268. flit 2 
1269. float 
1270. flock 
1271. flog 2 
1272. flood 
1273. floor 
1274. flop 2 
1275. flounder 
1276. flourish 4
1277. flout 
1278. flow 
1279. flower 
1280. fluctuate 1 
1281. flush 4
1282. fluster 
1283. flutter 
1284. fly + 
1285. focus 
1286. foil 
1287. fold 
1288. follow 
1289. fool 
1290. forbid 2 + 
1291. force 1 
1292. ford 
1293. forecast 
1294. forgo 4 + RB
1295. foresee + RB 
1296. foreshadow 
1297. foretell + 
1298. forfeit 
1299. forge 1 
1300. forget 2 + 
1301. forgive 1 + 
1302. fork 
1303. form 
1304. formalize 1 
1305. format 2 
1306. formulate 1 
1307. forsake 1 + 
1308. fortify 3 
1309. forward 
1310. foster 
1311. foul 
1312. found 
1313. fracture 1 
1314. fragment 
1315. frame 1 
1316. free 1 RB 
1317. freeze 1 + 
1318. frequent 
1319. fret 2 
1320. frighten 
1321. front 
1322. frost 
1323. frown 
1324. frustrate 1 
1325. fry 3 
1326. fuel RB 
1327. fulfill 
1328. fumble 1 
1329. fume 1 
1330. function 
1331. fund 
1332. furnish 4
1333. furrow 
1334. further 
1335. fuss 4
1336. gag 2 
1337. gain 
1338. gallop 
1339. galvanize 1 
1340. gamble 1 
1341. garner 
1342. garnish 4
1343. gasp 
1344. gather 
1345. gauge 1 
1346. gaze 1 
1347. gear 
1348. generalize 1 
1349. generate 1 
1350. gesture 1 
1351. get 2 + 
1352. gift 
1353. giggle 1 
1354. gild 
1355. give 1 + 
1356. glance 1 
1357. glare 1 
1358. glaze 1 
1359. gleam 
1360. glean 
1361. glide 1 
1362. glimpse 1 
1363. glisten 
1364. glitter 
1365. glorify 3 
1366. gloss 4
1367. glow 
1368. glue 1 
1369. gnaw 
1370. go 4 + 
1371. goad 
1372. gobble 1 
1373. gossip 
1374. gouge 1 
1375. govern 
1376. grab 2 
1377. grace 1 
1378. grade 1 
1379. graduate 1 
1380. graft 
1381. grant 
1382. grapple 1 
1383. grasp 
1384. grate 1 
1385. gratify 3 
1386. graze 1 
1387. grease 1 
1388. greet 
1389. grieve 1 
1390. grill 
1391. grimace 1 
1392. grin 2 
1393. grind + 
1394. grip 2 
1395. gripe 1 
1396. grit 2 
1397. groan 
1398. groom 
1399. grope 1 
1400. ground 
1401. group 
1402. grow + LV
1403. growl 
1404. grumble 1 
1405. grunt 
1406. guarantee 1 RB 
1407. guard 
1408. guess 4
1409. guide 1 
1410. gulp 
1411. gush 4
1412. gut 2 
1413. hack 
1414. hail 
1415. halt 
1416. halve 1 
1417. hammer 
1418. hamper 
1419. hand 
1420. handcuff 
1421. handicap 2 
1422. handle 1 
1423. handwrite 1 +
1424. hang + 
1425. happen 
1426. harass 4
1427. harbor 
1428. harden 
1429. harm 
1430. harness 4
1431. harvest 
1432. hasten 
1433. hatch 4
1434. hate 1 
1435. haul 
1436. haunt 
1437. head 
1438. headline 1 
1439. heal 
1440. heap 
1441. hear + 
1442. heat 
1443. heave 1 
1444. heckle 1 
1445. hedge 1 
1446. heed 
1447. heighten 
1448. help 
1449. hem 2 
1450. herald 
1451. herd 
1452. hesitate 1 
1453. hide 1 + 
1454. highlight 
1455. hijack 
1456. hinder 
1457. hinge 1 
1458. hint 
1459. hire 1 
1460. hiss 4
1461. hit 2 + 
1462. hitch 4
1463. hobble 1 
1464. hoist 
1465. hold + 
1466. hole 1 
1467. hollow 
1468. hone 1 
1469. honor 
1470. hook 
1471. hoot 
1472. hop 2 
1473. hope 1 
1474. horrify 3 
1475. hospitalize 1 
1476. host 
1477. hound 
1478. house 1 
1479. hover 
1480. howl 
1481. huddle 1 
1482. hug 2 
1483. hum 2 
1484. humble 1 
1485. humiliate 1 
1486. hunch 4
1487. hunt 
1488. hurl 
1489. hurry 3 
1490. hurt + 
1491. hurtle 1 
1492. hush 4
1493. hustle 1 
1494. hypnotize 1 
1495. hypothesize 1 
1496. ice 1 
1497. idealize 1 
1498. identify 3 
1499. ignite 1 
1500. ignore 1 
1501. illuminate 1 
1502. illustrate 1 
1503. imagine 1 
1504. imitate 1 
1505. immerse 1 
1506. immortalize 1 
1507. impair 
1508. impale 1 
1509. impart 
1510. impeach 4
1511. impede 1 
1512. impel 2 
1513. impinge 1 
1514. implant 
1515. implement 
1516. implicate 1 
1517. implore 1 
1518. imply 3 
1519. import 
1520. impose 1 
1521. impound 
1522. impoverish 4
1523. impress 4
1524. imprint 
1525. imprison 
1526. improve 1 
1527. improvise 1 
1528. impute 1 
1529. inaugurate 1 
1530. incapacitate 1 
1531. incarcerate 1 
1532. incense 1 
1533. inch 4
1534. incline 1 
1535. include 1 
1536. incorporate 1 
1537. increase 1 
1538. incubate 1 
1539. incur 2 
1540. indebt 
1541. indent 
1542. index 4
1543. indicate 1 
1544. indict 
1545. individualize 1 
1546. induce 1 
1547. indulge 1 
1548. industrialize 1 
1549. infect 
1550. infer 2 
1551. infest 
1552. infiltrate 1 
1553. inflame 1 
1554. inflate 1 
1555. inflict 
1556. influence 1 
1557. inform 
1558. infringe 1 
1559. infuriate 1 
1560. infuse 1 
1561. ingest 
1562. ingrain 
1563. inhabit 
1564. inhale 1 
1565. inherit 
1566. inhibit 
1567. initial 
1568. initiate 1 
1569. inject 
1570. injure 1 
1571. inlay 
1572. innovate 1 
1573. inquire 1 
1574. inscribe 1 
1575. insert 
1576. insinuate 1 
1577. insist 
1578. inspect 
1579. inspire 1 
1580. install 
1581. instigate 1 
1582. instill 
1583. institute 1 
1584. institutionalize 1 
1585. instruct 
1586. insulate 1 
1587. insult 
1588. insure 1 
1589. integrate 1 
1590. intend 
1591. intensify 3 
1592. intercept 
1593. interchange 1 
1594. interest 
1595. interfere 1 
1596. interject 
1597. interlace 1 
1598. intern 
1599. internalize 1 
1600. interpret 
1601. interrelate 1 
1602. interrogate 1 
1603. interrupt 
1604. intersperse 1 
1605. intertwine 1 
1606. intervene 1 
1607. interview 
1608. intimidate 1 
1609. intoxicate 1 
1610. intrigue 1 
1611. introduce 1 
1612. intrude 1 
1613. inundate 1 
1614. invade 1 
1615. invalidate 1 
1616. invent 
1617. inventory 3 
1618. invert 
1619. invest 
1620. investigate 1 
1621. invite 1 
1622. invoke 1 
1623. involve 1 
1624. irk 
1625. iron 
1626. irradiate 1 
1627. irritate 1 
1628. isolate 1 
1629. issue 1 
1630. itch 4
1631. itemize 1 
1632. jab 2 
1633. jail 
1634. jam 2 
1635. jar 2 
1636. jeer 
1637. jeopardize 1 
1638. jerk 
1639. jettison 
1640. jog 2 
1641. join 
1642. joke 1 
1643. jolt 
1644. jostle 1 
1645. journey 
1646. judge 1 
1647. juggle 1 
1648. jumble 1 
1649. jump 
1650. justify 3 
1651. juxtapose 1 
1652. keep + 
1653. kick 
1654. kid 2 
1655. kill 
1656. kiss 4
1657. kneel + 
1658. knight 
1659. knit 2 + 
1660. knock 
1661. knot 2 
1662. know + 
1663. label 
1664. labor 
1665. lace 1 
1666. lack 
1667. lag 2 
1668. lament 
1669. laminate 1 
1670. land 
1671. landscape 1 
1672. lap 2 
1673. lapse 1 
1674. lash 4
1675. last 
1676. latch 4
1677. laud 
1678. laugh 
1679. launch 4
1680. launder 
1681. lavish 4
1682. lay + 
1683. layer 
1684. leach 4
1685. lead + 
1686. leak 
1687. lean 
1688. leap + 
1689. learn 
1690. lease 1 
1691. leave 1 + 
1692. lecture 1 
1693. leer 
1694. legalize 1 
1695. legislate 1 
1696. lend + 
1697. lengthen 
1698. lessen 
1699. let 2 + 
1700. level 
1701. leverage 1 
1702. levy 3 
1703. liberate 1 
1704. license 1 
1705. lick 
1706. lie 1 + RB 
1707. lift 
1708. light 
1709. lighten 
1710. like 1 
1711. liken 
1712. limit 
1713. limp 
1714. line 1 
1715. linger 
1716. link 
1717. liquidate 1 
1718. list 
1719. listen 
1720. litigate 1 
1721. litter 
1722. live 1 
1723. load 
1724. loan 
1725. loath 
1726. lob 2 
1727. lobby 3 
1728. localize 1 
1729. locate 1 
1730. lock 
1731. lodge 1 
1732. log 2 
1733. long 
1734. look LV
1735. loom 
1736. loop 
1737. loosen 
1738. loot 
1739. lose 1 + 
1740. lounge 1 
1741. love 1 
1742. lower 
1743. lull 
1744. lumber 
1745. lump 
1746. lunch 4
1747. lunge 1 
1748. lurch 4
1749. lurk 
1750. magnify 3 
1751. mail 
1752. maim 
1753. maintain 
1754. make 1 + 
1755. man 2 
1756. manage 1 
1757. maneuver 
1758. mangle 1 
1759. manicure 1 
1760. manifest 
1761. manipulate 1 
1762. manufacture 1 
1763. map 2 
1764. march 4
1765. marginalize 1 
1766. mark 
1767. market 
1768. maroon 
1769. marry 3 
1770. marshal 
1771. marvel 
1772. mash 4
1773. mask 
1774. mass 4
1775. massacre 1 
1776. massage 1 
1777. master 
1778. mastermind 
1779. match 4
1780. materialize 1 
1781. matter 
1782. mature 1 
1783. maul 
1784. maximize 1 
1785. mean + 
1786. meander 
1787. measure 1 
1788. meddle 1 
1789. mediate 1 
1790. meet + 
1791. mellow 
1792. melt 
1793. memorize 1 
1794. mend 
1795. mention 
1796. mentor 
1797. merge 1 
1798. merit 
1799. mesmerize 1 
1800. mess 4
1801. migrate 1 
1802. milk 
1803. mill 
1804. mimic RB 
1805. mince 1 
1806. mind 
1807. mine 1 
1808. mingle 1 
1809. minimize 1 
1810. mint 
1811. mirror 
1812. misinterpret 
1813. misjudge 1 
1814. mislay +
1815. mislead +
1816. misplace 1 
1817. misrepresent 
1818. miss 4
1819. misspeak +
1820. misspell + 
1821. mistake 1 + 
1822. misuse 1 
1823. mitigate 1 
1824. mix 4
1825. moan 
1826. mob 2 
1827. mobilize 1 
1828. mock 
1829. model 
1830. moderate 1 
1831. modernize 1 
1832. modify 3 
1833. modulate 1 
1834. moisten 
1835. mold 
1836. monitor 
1837. moor 
1838. mop 2 
1839. mope 1 
1840. mortify 3 
1841. motion 
1842. motivate 1 
1843. motorize 1 
1844. mount 
1845. mourn 
1846. mouth 
1847. move 1 
1848. mow + 
1849. muddle 1 
1850. muffle 1 
1851. mug 2 
1852. multiply 3 
1853. mumble 1 
1854. murder 
1855. murmur 
1856. muscle 1 
1857. muse 1 
1858. muster 
1859. mutate 1 
1860. mute 1 
1861. mutilate 1 
1862. mutter 
1863. mystify 3 
1864. nab 2 
1865. nag 2 
1866. nail 
1867. name 1 
1868. narrate 1 
1869. narrow 
1870. nationalize 1 
1871. navigate 1 
1872. near 
1873. necessitate 1 
1874. need 
1875. needle 1 
1876. negate 1 
1877. neglect 
1878. negotiate 1 
1879. nest 
1880. nestle 1 
1881. net 2 
1882. network 
1883. neutralize 1 
1884. nibble 1 
1885. nick 
1886. nickname 1 
1887. nip 2 
1888. nod 2 
1889. nominate 1 
1890. normalize 1 
1891. nose 1 
1892. note 1 
1893. notice 1 
1894. notify 3 
1895. nudge 1 
1896. nullify 3 
1897. numb 
1898. number 
1899. nurse 1 
1900. nurture 1 
1901. nuzzle 1 
1902. obey 
1903. object 
1904. oblige 1 
1905. obliterate 1 
1906. obscure 1 
1907. observe 1 
1908. obsess 4
1909. obstruct 
1910. obtain 
1911. occasion 
1912. occupy 3 
1913. occur 2 
1914. offend 
1915. offer 
1916. officiate 1 
1917. oil 
1918. omit 2 
1919. ooze 1 
1920. open 
1921. operate 1 
1922. oppose 1 
1923. oppress 4
1924. opt 
1925. optimize 1 
1926. orchestrate 1 
1927. ordain 
1928. order 
1929. organize 1 
1930. orientate 1 
1931. originate 1 
1932. oust 
1933. outclass 4
1934. outlaw 
1935. outline 1 
1936. outlive 1 
1937. outnumber 
1938. outrage 1 
1939. outrun 2 +
1940. outstretch 4
1941. outweigh 
1942. overcome 1 + 
1943. overcrowd 
1944. overdo 4 + 
1945. overeat +
1946. overestimate 1 
1947. overflow 
1948. overhaul 
1949. overhear + 
1950. overheat 
1951. overlap 2 
1952. overload 
1953. overlook 
1954. overpower 
1955. overrule 1 
1956. oversee + RB 
1957. overshadow 
1958. oversleep +
1959. overstate 1 
1960. overtake 1 + 
1961. overthrow + 
1962. overturn 
1963. overwhelm 
1964. owe 1 
1965. own 
1966. pace 1 
1967. pack 
1968. package 1 
1969. pad 2 
1970. paddle 1 
1971. page 1 
1972. paint 
1973. pair 
1974. pamper 
1975. pan 2 
1976. panel 
1977. panic RB 
1978. pant 
1979. parachute 1 
1980. parade 1 
1981. paralyze 1 
1982. pardon 
1983. pare 1 
1984. park 
1985. parley 
1986. parody 
1987. parrot 
1988. part 
1989. participate 1 
1990. partition 
1991. partner 
1992. pass 4
1993. paste 1 
1994. pat 2 
1995. patch 4
1996. patent 
1997. patrol 2 
1998. patronize 1 
1999. pattern 
2000. pause 1 
2001. pave 1 
2002. paw 
2003. pay + 
2004. peak 
2005. peck 
2006. pedal 
2007. peel 
2008. peep 
2009. peer 
2010. peg 2 
2011. pelt 
2012. penalize 1 
2013. pencil 
2014. penetrate 1 
2015. pepper 
2016. perceive 1 
2017. perch 4
2018. perfect 
2019. perform 
2020. perfume 1 
2021. perish 4
2022. permeate 1 
2023. permit 2 
2024. perpetrate 1 
2025. perpetuate 1 
2026. perplex 4
2027. persecute 1 
2028. persevere 1 
2029. persist 
2030. personalize 1 
2031. personify 3 
2032. persuade 1 
2033. perturb 
2034. pervade 1 
2035. pester 
2036. petition 
2037. petrify 3 
2038. phase 1 
2039. phone 1 
2040. photocopy 3 
2041. photograph 
2042. phrase 1 
2043. pick 
2044. pickle 1 
2045. picture 1 
2046. pierce 1 
2047. pile 1 
2048. pilot 
2049. pin 2 
2050. pinch 4
2051. pine 1
2052. pinpoint 
2053. pioneer 
2054. pipe 1 
2055. pit 2 
2056. pitch 4
2057. pity 3 
2058. placate 1 
2059. place 1 
2060. plague 1 
2061. plan 2 
2062. plant 
2063. plaster 
2064. play 
2065. plead + 
2066. please 1 
2067. pledge 1 
2068. plod 2 
2069. plot 2 
2070. plow 
2071. pluck 
2072. plug 2 
2073. plummet 
2074. plump 
2075. plunder 
2076. plunge 1 
2077. ply 3 
2078. poach 4
2079. pocket 
2080. point 
2081. poise 1 
2082. poison 
2083. poke 1 
2084. polarize 1 
2085. police 1 
2086. polish 4
2087. poll 
2088. pollute 1 
2089. ponder 
2090. pool 
2091. pop 2 
2092. populate 1 
2093. portray 
2094. pose 1 
2095. position 
2096. possess 4
2097. post 
2098. postpone 1 
2099. postulate 1 
2100. pot 2 
2101. pounce 1 
2102. pound 
2103. pour 
2104. pout 
2105. powder 
2106. power 
2107. practice 1 
2108. praise 1 
2109. pray 
2110. preach 4
2111. precede 1 
2112. precipitate 1 
2113. preclude 1 
2114. predetermine 1 
2115. predicate 1 
2116. predict 
2117. preen 
2118. prefer 2 
2119. prejudice 1 
2120. preoccupy 3 
2121. prepare 1 
2122. prescribe 1 
2123. present 
2124. preserve 1 
2125. preside 1 
2126. press 4
2127. pressure 1 
2128. pressurize 1 
2129. presume 1 
2130. presuppose 1 
2131. pretend 
2132. prevail 
2133. prevent 
2134. preview 
2135. price 1 
2136. prick 
2137. pride 1 
2138. prime 1 
2139. primp 
2140. print 
2141. privatize 1 
2142. prize 1 
2143. probe 1 
2144. proceed 
2145. process 4
2146. proclaim 
2147. procure 1 
2148. prod 2 
2149. produce 1 
2150. profess 4
2151. profit 
2152. program 2 
2153. progress 4
2154. prohibit 
2155. project 
2156. proliferate 1 
2157. prolong 
2158. promise 1 
2159. promote 1 
2160. prompt 
2161. pronounce 1 
2162. proofread + 
2163. prop 2 
2164. propagate 1 
2165. propel 2 
2166. prophesize 1 RB
2167. propose 1 
2168. proscribe 1	
2169. prosecute 1 
2170. prosper 
2171. protect 
2172. protest 
2173. protract 
2174. protrude 1 
2175. prove 1 + LV
2176. provide 1 
2177. provoke 1 
2178. prowl 
2179. prune 1 
2180. pry 3 
2181. publicize 1 
2182. publish 4
2183. pucker 
2184. puff 
2185. pull 
2186. pummel 
2187. pump 
2188. punch 4
2189. punctuate 1 
2190. puncture 1 
2191. punish 4
2192. purchase 1 
2193. purge 1 
2194. purify 3 
2195. purport 
2196. purr 
2197. purse 1 
2198. pursue 1 
2199. push 4
2200. put 2 + 
2201. puzzle 1 
2202. quadruple 1 
2203. qualify 3 
2204. quantify 3 
2205. quarrel 
2206. quarter 
2207. quash 4
2208. quell 
2209. quench 4
2210. query 3 
2211. question 
2212. queue 1 
2213. quicken 
2214. quip 2 
2215. quit 2 + 
2216. quiver 
2217. quiz 2 4 
2218. quote 1 
2219. race 1 
2220. rack 
2221. radiate 1 
2222. rage 1 
2223. raid 
2224. rain 
2225. raise 1 
2226. rake 1 
2227. rally 3 
2228. ram 2 
2229. range 1 
2230. rank 
2231. ransack 
2232. rant 
2233. rat 2 
2234. rate 1 
2235. ratify 3 
2236. ration 
2237. rationalize 1 
2238. rattle 1 
2239. ravage 1 
2240. rave 1 
2241. raze 1 
2242. reach 4
2243. react 
2244. read + 
2245. readmit 2 
2246. reaffirm 
2247. realign 
2248. realize 1 
2249. reap 
2250. reappear 
2251. rear 
2252. rearrange 1 
2253. reason 
2254. reassemble 1 
2255. reassert 
2256. reassess 4
2257. reassure 1 
2258. rebel 2 
2259. rebound 
2260. rebuff 
2261. rebuke 1 
2262. recall 
2263. recapture 1 
2264. recede 1 
2265. receive 1 
2266. recess 4
2267. recharge 1 
2268. reciprocate 1 
2269. recite 1 
2270. reckon 
2271. reclaim 
2272. recline 1 
2273. recognize 1 
2274. recoil 
2275. recollect 
2276. recommend 
2277. reconcile 1 
2278. reconfigure 1 
2279. reconsider 
2280. reconstitute 1 
2281. reconstruct 
2282. reconvene 1 
2283. record 
2284. recount 
2285. recoup 
2286. recover 
2287. recreate 1 
2288. recruit 
2289. rectify 3 
2290. recycle 1 
2291. redden 
2292. redeem 
2293. redefine 1 
2294. redesign 
2295. redevelop 
2296. redirect 
2297. rediscover 
2298. redistribute 1 
2299. reduce 1 
2300. reel 
2301. refer 2 
2302. reference 1 
2303. refill 
2304. refine 1 
2305. reflect 
2306. reform 
2307. refrain 
2308. refresh 4
2309. refrigerate 1 
2310. refund 
2311. refurbish 4
2312. refuse 1 
2313. refute 1 
2314. regain 
2315. regard 
2316. register 
2317. regret 2 
2318. regulate 1 
2319. rehabilitate 1 
2320. rehearse 1 
2321. reign 
2322. reimburse 1 
2323. rein 
2324. reinforce 1 
2325. reinstate 1 
2326. reinterpret 
2327. reintroduce 1 
2328. reinvest 
2329. reissue 1 
2330. reiterate 1 
2331. reject 
2332. rejoice 1 
2333. rejoin 
2334. rekindle 1 
2335. relapse 1 
2336. relate 1 
2337. relax 4
2338. relay 
2339. release 1 
2340. relegate 1 
2341. relent 
2342. relieve 1 
2343. relinquish 4
2344. relish 4
2345. relocate 1 
2346. rely 3 
2347. remain LV
2348. remand 
2349. remark 
2350. remedy 3 
2351. remember 
2352. remind 
2353. remit 2 
2354. remove 1 
2355. rename 1 
2356. render 
2357. renege 1 
2358. renegotiate 1 
2359. renew 
2360. renounce 1 
2361. renovate 1 
2362. rent 
2363. reopen 
2364. reorganize 1 
2365. repair 
2366. repay + 
2367. repeal 
2368. repeat 
2369. repel 2 
2370. replace 1 
2371. replenish 4
2372. replicate 1 
2373. reply 3 
2374. report 
2375. repossess 4
2376. represent 
2377. repress 4
2378. reprieve 1 
2379. reprimand 
2380. reprint 
2381. reproach 4
2382. reproduce 1 
2383. reprogram 2 
2384. repulse 1 
2385. repute 1 
2386. request 
2387. require 1 
2388. requisition 
2389. reread +
2390. reschedule 1 
2391. rescind 
2392. rescue 1 
2393. research 4
2394. resell +
2395. resemble 1 
2396. resent 
2397. reserve 1 
2398. reset 2 + 
2399. reshuffle 1 
2400. reside 1 
2401. resign 
2402. resist 
2403. resolve 1 
2404. resort 
2405. respect 
2406. respond 
2407. rest 
2408. restart 
2409. restate 1 
2410. restore 1 
2411. restrain 
2412. restrict 
2413. restructure 1 
2414. result 
2415. resume 1 
2416. resurface 1 
2417. resurrect 
2418. retake 1 +
2419. retain 
2420. retaliate 1 
2421. reteach 4 +
2422. retell +
2423. rethink +
2424. retire 1 
2425. retort 
2426. retrace 1 
2427. retract 
2428. retreat 
2429. retrieve 1 
2430. return 
2431. reunite 1 
2432. reuse 1 
2433. rev 2 
2434. revamp 
2435. reveal 
2436. revel 
2437. reverberate 1 
2438. revere 1 
2439. reverse 1 
2440. revert 
2441. review 
2442. revile 1 
2443. revise 1 
2444. revisit 
2445. revive 1 
2446. revoke 1 
2447. revolt 
2448. revolutionize 1 
2449. revolve 1 
2450. reward 
2451. rework 
2452. rhyme 1 
2453. rib 2 
2454. rid 2 + 
2455. riddle 1 
2456. ride 1 + 
2457. ridicule 1 
2458. rig 2 
2459. right 
2460. ring + 
2461. rinse 1 
2462. rip 2 
2463. ripple 1 
2464. rise + 
2465. risk 
2466. rival 
2467. rivet 
2468. roam 
2469. roar 
2470. roast 
2471. rob 2 
2472. rock 
2473. rocket 
2474. roll 
2475. romp 
2476. root 
2477. rope 1 
2478. rot 2 
2479. rotate 1 
2480. round 
2481. rouse 1 
2482. route 
2483. row 
2484. rub 2 
2485. ruffle 1 
2486. ruin 
2487. rule 1 
2488. rumble 1 
2489. rummage 1 
2490. rumple 1 
2491. run 2 + 
2492. rupture 1 
2493. rush 4
2494. rust 
2495. rustle 1 
2496. sabotage 1 
2497. sack 
2498. sacrifice 1 
2499. sadden 
2500. saddle 1 
2501. safeguard 
2502. sag 2 
2503. sail 
2504. salt 
2505. salute 1 
2506. salvage 1 
2507. sample 1 
2508. sanction 
2509. sandwich 4
2510. sap 2 
2511. sass 4
2512. satisfy 3 
2513. saturate 1 
2514. saunter 
2515. save 1 
2516. savor 
2517. saw + 
2518. say + 
2519. scald 
2520. scale 1 
2521. scamper 
2522. scan 2 
2523. scar 2 
2524. scare 1 
2525. scatter 
2526. scavenge 1 
2527. scent 
2528. schedule 1 
2529. school 
2530. scoff 
2531. scold 
2532. scoop 
2533. scorch 4
2534. score 1 
2535. scorn 
2536. scour 
2537. scowl 
2538. scramble 1 
2539. scrap 2 
2540. scrape 1 
2541. scratch 4
2542. scrawl 
2543. scream 
2544. screech 4
2545. screen 
2546. screw 
2547. scribble 1 
2548. scroll 
2549. scrub 2 
2550. scrutinize 1 
2551. sculpt 
2552. scurry 3 
2553. scuttle 1 
2554. seal 
2555. search 4
2556. season 
2557. seat 
2558. seclude 1 
2559. secrete 1 
2560. secure 1 
2561. seduce 1 
2562. see 1 + RB 
2563. seed 
2564. seek + 
2565. seem LV
2566. seep 
2567. seethe 1 
2568. segment 
2569. segregate 1 
2570. seize 1 
2571. select 
2572. sell + 
2573. send + 
2574. sense 1 
2575. sentence 1 
2576. separate 1 
2577. sequence 1 
2578. serve 1 
2579. service 1 
2580. set 2 + 
2581. settle 1 
2582. sever 
2583. sew + 
2584. shade 1 
2585. shadow 
2586. shake 1 + 
2587. shame 
2588. shape 1 
2589. share 1 
2590. sharpen 
2591. shatter 
2592. shave 1 + 
2593. shear + 
2594. sheath 
2595. shed 2 + 
2596. shell 
2597. shelter 
2598. shelve 1 
2599. shepherd 
2600. shield 
2601. shift 
2602. shimmer 
2603. shine 1 + 
2604. ship 2 
2605. shiver 
2606. shock 
2607. shoot + 
2608. shop 2 
2609. shorten 
2610. shoulder 
2611. shout 
2612. shove 1 
2613. show + 
2614. shower 
2615. shred 2 
2616. shriek 
2617. shrink + 
2618. shrivel 
2619. shroud 
2620. shrug 2 
2621. shudder 
2622. shuffle 1 
2623. shun 2 
2624. shunt 
2625. shut 2 + 
2626. shutter 
2627. sicken 
2628. side 1 
2629. sideline 1 
2630. sidle 1 
2631. sift 
2632. sigh 
2633. sight 
2634. sign 
2635. signal 
2636. signify 3 
2637. silence 1 
2638. silhouette 1 
2639. simplify 3 
2640. simulate 1 
2641. sing + 
2642. singe 1 
2643. single 1 
2644. sink + 
2645. sip 2 
2646. sire 1 
2647. sit 2 + 
2648. situate 1 
2649. size 1 
2650. sketch 4
2651. skew 
2652. ski 
2653. skid 2 
2654. skim 2 
2655. skin 2 
2656. skip 2 
2657. skirt 
2658. slacken 
2659. slam 2 
2660. slant 
2661. slap 2 
2662. slash 4
2663. slate 1 
2664. slaughter 
2665. slay + 
2666. sleep + 
2667. slice 1 
2668. slide 1 + 
2669. sling + 
2670. slink 
2671. slip 2 
2672. slit 2 + 
2673. slither 
2674. slope 1 
2675. slouch 4
2676. slow 
2677. slug 2 
2678. slump 
2679. slur 2 
2680. smack 
2681. smash 4
2682. smear 
2683. smell LV
2684. smile 1 
2685. smirk 
2686. smoke 1 
2687. smooth 
2688. smother 
2689. smudge 1 
2690. smuggle 1 
2691. snake 1 
2692. snap 2 
2693. snare 1 
2694. snarl 
2695. snatch 4
2696. sneak +
2697. sneer 
2698. sneeze 1 
2699. snicker 
2700. sniff 
2701. snoop 
2702. snore 1 
2703. snort 
2704. snow 
2705. snub 2 
2706. snuff 
2707. snuggle 1 
2708. soak 
2709. soar 
2710. sob 2 
2711. socialize 1 
2712. soften 
2713. soil 
2714. solicit 
2715. solve 1 
2716. sooth 
2717. sort 
2718. sound LV
2719. sour 
2720. sow + 
2721. space 1 
2722. span 2 
2723. spare 1 
2724. spark 
2725. sparkle 1 
2726. spatter 
2727. spawn 
2728. speak + 
2729. spear 
2730. spearhead 
2731. specialize 1 
2732. specify 3 
2733. speckle 1 
2734. speculate 1 
2735. speed + 
2736. spell + 
2737. spend + 
2738. spice 1 
2739. spike 1 
2740. spill 
2741. spin 2 + 
2742. spiral 
2743. spirit 
2744. spit + 
2745. spite 1 
2746. splash 4
2747. splatter 
2748. splice 1 
2749. splinter 
2750. split 2 + 
2751. splutter 
2752. spoil 
2753. sponsor 
2754. spoon 
2755. sport 
2756. spot 2 
2757. sprawl 
2758. spray 
2759. spread + 
2760. spring + 
2761. sprinkle 1 
2762. sprint 
2763. sprout 
2764. spur 2 
2765. spurn 
2766. spurt 
2767. spy 3 
2768. squander 
2769. square 1 
2770. squash 4
2771. squat 2 
2772. squeak 
2773. squeal 
2774. squeeze 1 
2775. squint 
2776. squirm 
2777. squirt 
2778. stab 2 
2779. stabilize 1 
2780. stable 1 
2781. stack 
2782. staff 
2783. stage 1 
2784. stagger 
2785. stain 
2786. stake 1 
2787. stalk 
2788. stall 
2789. stammer 
2790. stamp 
2791. stand + 
2792. standardize 1 
2793. stare 1 
2794. start 
2795. startle 1 
2796. starve 1 
2797. stash 4
2798. state 1 
2799. station 
2800. stay LV
2801. steady 3 
2802. steal + 
2803. steam 
2804. steer 
2805. stem 2 
2806. step 2 
2807. stereotype 1 
2808. stick + 
2809. stiffen 
2810. stifle 1 
2811. stimulate 1 
2812. sting + 
2813. stink + 
2814. stipulate 1 
2815. stir 2 
2816. stitch 4
2817. stock 
2818. stomp 
2819. stone 1 
2820. stoop 
2821. stop 2 
2822. store 1 
2823. storm 
2824. stow 
2825. straddle 1 
2826. straighten 
2827. strain 
2828. strand 
2829. strangle 1 
2830. strap 2 
2831. strategize 1 
2832. stratify 3 
2833. stray 
2834. streak 
2835. stream 
2836. streamline 1 
2837. strengthen 
2838. stress 4
2839. stretch 4
2840. stride 1 + 
2841. strike 1 + 
2842. string + 
2843. strip 2 
2844. strive 1 + 
2845. stroke 1 
2846. structure 1 
2847. struggle 1 
2848. strut 2 
2849. stub 2 
2850. study 3 
2851. stuff 
2852. stumble 1 
2853. stump 
2854. stun 2 
2855. stunt 
2856. stutter 
2857. style 1 
2858. stylize 1 
2859. subdivide 1 
2860. subdue 1 
2861. subject 
2862. sublet 2 + 
2863. submerge 1 
2864. submit 2 
2865. subordinate 1 
2866. subscribe 1 
2867. subside 1 
2868. subsidize 1 
2869. substantiate 1 
2870. substitute 1 
2871. subsume 1 
2872. subtract 
2873. subvert 
2874. succeed 
2875. succumb 
2876. suck 
2877. sue 1 
2878. suffer 
2879. suffice 1 
2880. suffocate 1 
2881. suggest 
2882. suit 
2883. summarize 1 
2884. summon 
2885. superimpose 1 
2886. supersede 1 
2887. supervise 1 
2888. supplant 
2889. supplement 
2890. supply 3 
2891. support 
2892. suppose 1 
2893. suppress 4
2894. surface 1 
2895. surge 1 
2896. surmise 1 
2897. surmount 
2898. surpass 4
2899. surprise 1 
2900. surrender 
2901. surround 
2902. survey 
2903. survive 1 
2904. suspect 
2905. suspend 
2906. sustain 
2907. swagger 
2908. swallow 
2909. swamp 
2910. swap 2 
2911. swarm 
2912. sway 
2913. swear + 
2914. sweat + 
2915. sweep + 
2916. swell 
2917. swerve 1 
2918. swim 2 + 
2919. swing + 
2920. swirl 
2921. switch 4
2922. swivel 
2923. swoop 
2924. symbolize 1 
2925. sympathize 1 
2926. synthesize 1 
2927. systematize 1 
2928. systemize 1 
2929. table 1 
2930. tabulate 1 
2931. tack 
2932. tackle 1 
2933. tag 2 
2934. tail 
2935. tailor 
2936. taint 
2937. take 1 + 
2938. talk 
2939. tame 
2940. tamper 
2941. tan 2 
2942. tangle 1 
2943. tap 2 
2944. tape 1 
2945. taper 
2946. target 
2947. tarnish 4
2948. taste 1 LV
2949. tatter 
2950. taunt 
2951. tax 4
2952. teach 4 + 
2953. team 
2954. tear + 
2955. tease 1 
2956. telephone 1 
2957. televise 1 
2958. tell + 
2959. tempt 
2960. tend 
2961. tender 
2962. tense 1 
2963. term 
2964. terminate 1 
2965. terrify 3 
2966. terrorize 1 
2967. test 
2968. testify 3 
2969. tether 
2970. texture 1 
2971. thank 
2972. thatch 4
2973. thaw 
2974. theorize 1 
2975. thicken 
2976. thin 2 
2977. think + 
2978. thrash 4
2979. thread 
2980. threaten 
2981. thrill 
2982. thrive 1 + 
2983. throb 2 
2984. throw + 
2985. thrust + 
2986. thud 2 
2987. thumb 
2988. thump 
2989. thunder 
2990. thwart 
2991. tick 
2992. tickle 1 
2993. tie 1 RB 
2994. tighten 
2995. tile 1 
2996. till 
2997. tilt 
2998. time 1 
2999. tinge 1 RB 
3000. tingle 1 
3001. tint 
3002. tip 2 
3003. tiptoe RB 
3004. tire 1 
3005. title 1 
3006. toast 
3007. toil 
3008. tolerate 1 
3009. tone 
3010. top 2 
3011. topple 1 
3012. torment 
3013. torture 1 
3014. toss 4
3015. total 
3016. totter 
3017. touch 4
3018. tour 
3019. tout 
3020. tow 
3021. tower 
3022. toy 
3023. trace 1 
3024. track 
3025. trade 1 
3026. trail 
3027. train 
3028. tramp 
3029. trample 1 
3030. transact 
3031. transcend 
3032. transcribe 1 
3033. transfer 2 
3034. transfix 4
3035. transform 
3036. translate 1 
3037. transmit 2 
3038. transmute 1 
3039. transpire 1 
3040. transplant 
3041. transport 
3042. transpose 1 
3043. trap 2 
3044. travel 
3045. traverse 1 
3046. tread + 
3047. treasure 1 
3048. treat 
3049. tremble 1 
3050. trick 
3051. trickle 1 
3052. trigger 
3053. trim 2 
3054. trip 2 
3055. triple 1 
3056. triumph 
3057. trot 2 
3058. trouble 1 
3059. troubleshoot + 
3060. trudge 1 
3061. truncate 1 
3062. truss 4
3063. trust 
3064. try 3 
3065. tuck 
3066. tug 2 
3067. tumble 1 
3068. tune 1 
3069. turn LV
3070. tutor 
3071. twinkle 1 
3072. twirl 
3073. twist 
3074. twitch 4
3075. type 1 
3076. typify 3 
3077. unarm 
3078. unbalance 1 
3079. unbutton 
3080. uncover 
3081. undercut 2 +
3082. underestimate 1 
3083. undergo 4 + 
3084. underline 1 
3085. undermine 1 
3086. understand + 
3087. understate 1 
3088. undertake 1 + 
3089. undervalue 1 
3090. undo 4 + 
3091. undress 4
3092. unearth 
3093. unfasten 
3094. unfold 
3095. unfurl 
3096. unify 3 
3097. unite 1 
3098. unleash 4
3099. unload 
3100. unlock 
3101. unpack 
3102. unravel 
3103. unroll 
3104. untie 1 
3105. unveil 
3106. unwind +
3107. unwrap 2 
3108. unzip 2 
3109. up 2 
3110. update 1 
3111. upgrade 1 
3112. uphold + 
3113. upholster 
3114. uproot 
3115. upset 2 + 
3116. upstage 1 
3117. urge 1 
3118. use 1 
3119. usher 
3120. usurp 
3121. utilize 1 
3122. utter 
3123. vacate 1 
3124. vaccinate 1 
3125. validate 1 
3126. value 1 
3127. vandalize 1 
3128. vanish 4
3129. varnish 4
3130. vary 3 
3131. vault 
3132. veer 
3133. vegetate 1 
3134. venerate 1 
3135. vent 
3136. ventilate 1 
3137. venture 1 
3138. verbalize 1 
3139. verify 3 
3140. vest 
3141. vet 2 
3142. veto 4
3143. vibrate 1 
3144. victimize 1 
3145. view 
3146. vindicate 1 
3147. violate 1 
3148. visit 
3149. visualize 1 
3150. voice 1 
3151. void 
3152. volunteer 
3153. vomit 
3154. vote 1 
3155. vow 
3156. wad 2 
3157. waddle 1 
3158. wade 1 
3159. wag 2
3160. wage 1 
3161. wail 
3162. wait 
3163. waive 1 
3164. wake 1 + 
3165. waken 
3166. walk 
3167. wall 
3168. wander 
3169. wane 
3170. want 
3171. warm 
3172. warn 
3173. warp 
3174. warrant 
3175. wash 4
3176. waste 1 
3177. watch 4
3178. water 
3179. waterlog 2 
3180. wave 1 
3181. waver 
3182. wax 4
3183. weaken 
3184. wean 
3185. wear + 
3186. weather 
3187. weave 1 + 
3188. wed 2 
3189. wedge 1 
3190. weep + 
3191. weigh 
3192. welcome 1 
3193. weld 
3194. whack 
3195. wheel 
3196. whimper 
3197. whine 1 
3198. whip 2 
3199. whirl 
3200. whisk 
3201. whisper 
3202. whistle 1 
3203. whiten 
3204. whitewash 4
3205. whittle 1 
3206. widen 
3207. wield 
3208. wiggle 1 
3209. will 
3210. win + 
3211. wince 1 
3212. wind + 
3213. wink 
3214. wipe 1 
3215. wire 1 
3216. wish 4
3217. withdraw + 
3218. wither 
3219. withhold + 
3220. withstand + 
3221. witness 4
3222. wobble 1 
3223. wonder 
3224. woo 4
3225. word 
3226. work 
3227. worry 3 
3228. worsen 
3229. worship RB 
3230. wound 
3231. wrap 2 
3232. wreck 
3233. wrench 4
3234. wrestle 1 
3235. wriggle 1 
3236. wring + 
3237. wrinkle 1 
3238. write 1 + 
3239. writhe 1 
3240. x-ray 
3241. yak 2 
3242. yank 
3243. yawn 
3244. yearn 
3245. yell 
3246. yelp 
3247. yield 
3248. zap 2 
3249. zip 2 
3250. zoom';


$done = 0;
$found = 0;
$matched = 0;
foreach(explode("\n",$list) as $count => $item){

    $words = explode(' ', $item);

    //Check to see if it exists:
    $current_en = $this->Entities_model->en_fetch(array(
        'LOWER(en_name)' => $words[1],
    ));


    if(count($current_en) > 0){

        $found++;

        //Found, IS part of verbs?
        if(count($this->Links_model->ln_fetch(array(
                'ln_type_entity_id' => 4230, //Raw link
                'ln_parent_entity_id' => 5008,
                'ln_child_entity_id' => $current_en[0]['en_id'],
            )))>0){
            $matched++;
        } else {
            echo $count.' NOT VERB '.ucwords($words[1]).'<br />';
        }

    } else {

        $done++;

        //Not found:
        if(isset($_GET['update'])){
            //Create Verb:
            $entity_new = $this->Entities_model->en_create(array(
                'en_name' => ucwords($words[1]),
                'en_status_entity_id' => 6181, //Entity Published
            ), false, 1);

            if(isset($entity_new['en_id']) && $entity_new['en_id'] > 0){
                //Link to verbs:
                $this->Links_model->ln_create(array(
                    'ln_type_entity_id' => 4230, //Raw link
                    'ln_parent_entity_id' => 5008,
                    'ln_creator_entity_id' => 1,
                    'ln_child_entity_id' => $entity_new['en_id'],
                ));
            } else {
                echo $count.' ] '.ucwords($words[1]).'<br />';
            }
        }
    }
}

echo '<hr />'.$found.' found, '.$matched.' matched, '.$done.' added';

exit;
//Define all moderation functions:
$en_all_4737 = $this->config->item('en_all_4737'); // Intent Statuses
$en_all_6177 = $this->config->item('en_all_6177'); //Entity Statuses

$moderation_tools = array(
    '/miner_app/admin_tools/in_replace_outcomes' => 'Intent Search/Replace Outcomes',
    '/miner_app/admin_tools/in_invalid_outcomes' => 'Intent Invalid Outcomes',
    '/miner_app/admin_tools/actionplan_debugger' => 'My Action Plan Debugger',
    '/miner_app/admin_tools/en_icon_search' => 'Entity Icon Search',
    '/miner_app/admin_tools/moderate_intent_notes' => 'Moderate Intent Notes',
    '/miner_app/admin_tools/identical_intent_outcomes' => 'Identical Intent Outcomes',
    '/miner_app/admin_tools/identical_entity_names' => 'Identical Entity Names',
    '/miner_app/admin_tools/or__children' => 'List OR Intents + Answers',
    '/miner_app/admin_tools/orphan_intents' => 'Orphan Intents',
    '/miner_app/admin_tools/orphan_entities' => 'Orphan Entities',
    '/miner_app/admin_tools/assessment_marks_list_all' => 'Completion Marks List All',
    '/miner_app/admin_tools/assessment_marks_birds_eye' => 'Completion Marks Birds Eye View',
    '/miner_app/admin_tools/compose_test_message' => 'Compose Test Message',
    '/miner_app/admin_tools/sync_in_verbs' => 'Sync Intent Verbs',
);

$cron_jobs = array(
    '/intents/cron__sync_common_base' => 'Sync Common Base Metadata',
    '/intents/cron__sync_extra_insights' => 'Sync Extra Insights Metadata',
    '/entities/cron__update_trust_score' => 'Update All Entity Trust Scores',
    '/links/cron__sync_algolia' => 'Sync Algolia Index [Limited calls!]',
    '/links/cron__sync_gephi' => 'Sync Gephi Graph Index',
    '/links/cron__clean_metadatas' => 'Clean Unused Metadata Variables',
);


$developer_tools = array(
    '/miner_app/platform_cache' => 'Platform PHP Cache',
    '/miner_app/my_session' => 'My Session Variables',
    '/miner_app/php_info' => 'Server PHP Info',
);



if(!$action) {

    $en_all_7368 = $this->config->item('en_all_7368');
    echo '<h1>'.$en_all_7368[6287]['m_icon'].' '.$en_all_7368[6287]['m_name'].' <a href="/entities/6287" style="font-size: 0.5em; color: #999;" title="'.$en_all_7368[6287]['m_name'].' entity controlling this tool" data-toggle="tooltip" data-placement="right">@6287</a></h1>';

    echo '<div class="list-group actionplan_list grey_list maxout">';
    foreach ($moderation_tools as $tool_key => $tool_name) {
        echo '<a href="' . $tool_key . '" class="list-group-item">';
        echo '<span class="pull-right">';
        echo '<span class="badge badge-primary fr-bgd"><i class="fas fa-angle-right"></i></span>';
        echo '</span>';
        echo '<span style="color:#222; font-weight:500; font-size:1.2em;">'.$tool_name.'</span>';
        echo '</a>';
    }
    echo '</div>';


    echo '<h3>Developer Tools</h3>';
    echo '<div class="list-group actionplan_list grey_list maxout">';
    foreach ($developer_tools as $tool_key => $tool_name) {
        echo '<a href="' . $tool_key . '" target="_blank" class="list-group-item">';
        echo '<span class="pull-right">';
        echo '<span class="badge badge-primary fr-bgd"><i class="fas fa-external-link"></i></span>';
        echo '</span>';
        echo '<span style="color:#222; font-weight:500; font-size:1.2em;">'.$tool_name.'</span>';
        echo '</a>';

    }
    echo '</div>';



    echo '<h3>Automated Cron Jobs</h3>';
    echo '<div class="list-group actionplan_list grey_list maxout">';
    foreach ($cron_jobs as $tool_key => $tool_name) {
        echo '<a href="' . $tool_key . '" target="_blank" class="list-group-item">';
        echo '<span class="pull-right">';
        echo '<span class="badge badge-primary fr-bgd"><i class="fas fa-external-link"></i></span>';
        echo '</span>';
        echo '<span style="color:#222; font-weight:500; font-size:1.2em;">'.$tool_name.'</span>';
        echo '</a>';

    }
    echo '</div>';

} elseif($action=='moderate_intent_notes'){

    //Fetch pending notes:
    $pendin_in_notes = $this->Links_model->ln_fetch(array(
        'ln_status_entity_id IN (' . join(',', $this->config->item('en_ids_7364')) . ')' => null, //Link Statuses Incomplete
        'ln_type_entity_id IN (' . join(',', $this->config->item('en_ids_4485')) . ')' => null, //All Intent Notes
    ), array('in_child'), $this->config->item('items_per_page'), 0, array('ln_id' => 'ASC'));

    echo '<div class="row">';
    echo '<div class="'.$this->config->item('css_column_1').'">';
    echo '<ul class="breadcrumb"><li><a href="/miner_app/admin_tools">Admin Tools</a></li><li><b>'.$moderation_tools['/miner_app/admin_tools/'.$action].'</b></li></ul>';
    //List intents and allow to modify and manage intent notes:
    if(count($pendin_in_notes) > 0){
        foreach($pendin_in_notes as $pendin_in_note){
            echo echo_in($pendin_in_note, 0);
        }
    } else {
        echo '<div class="alert alert-success"><i class="fas fa-check-circle"></i> No Pending Intent Notes at this time</div>';
    }

    echo '</div>';
    echo '<div class="'.$this->config->item('css_column_2').'">';
    $this->load->view('view_miner_app/in_right_column');
    echo '</div>';
    echo '</div>';


} elseif($action=='orphan_intents') {

    echo '<ul class="breadcrumb"><li><a href="/miner_app/admin_tools">Admin Tools</a></li><li><b>'.$moderation_tools['/miner_app/admin_tools/'.$action].'</b></li></ul>';

    $orphan_ins = $this->Intents_model->in_fetch(array(
        ' NOT EXISTS (SELECT 1 FROM table_links WHERE in_id=ln_child_intent_id AND ln_type_entity_id IN (' . join(',', $this->config->item('en_ids_4486')) . ') AND ln_status_entity_id IN ('.join(',', $this->config->item('en_ids_7360')) /* Link Statuses Active */.')) ' => null,
        'in_status_entity_id IN (' . join(',', $this->config->item('en_ids_7356')) . ')' => null, //Intent Statuses Active
        'in_id !=' => $this->config->item('in_mission_id'), //Mission does not have parents
        'in_id NOT IN (' . join(',', $this->config->item('in_system_lock')) . ')' => null,
    ));

    if(count($orphan_ins) > 0){

        //List orphans:
        foreach ($orphan_ins as $count => $orphan_in) {

            //Show intent:
            echo '<div>'.($count+1).') <span data-toggle="tooltip" data-placement="right" title="'.$en_all_4737[$orphan_in['in_status_entity_id']]['m_name'].': '.$en_all_4737[$orphan_in['in_status_entity_id']]['m_desc'].'">' . $en_all_4737[$orphan_in['in_status_entity_id']]['m_icon'] . '</span> <a href="/intents/'.$orphan_in['in_id'].'"><b>'.$orphan_in['in_outcome'].'</b></a>';

            //Do we need to remove?
            if($command1=='remove_all'){

                //Remove intent links:
                $links_removed = $this->Intents_model->in_unlink($orphan_in['in_id'] , $session_en['en_id']);

                //Remove intent:
                $this->Intents_model->in_update($orphan_in['in_id'], array(
                    'in_status_entity_id' => 6182, /* Intent Removed */
                ), true, $session_en['en_id']);

                //Show confirmation:
                echo ' [Intent + '.$links_removed.' links Removed]';

            }

            //Done showing the intent:
            echo '</div>';
        }

        //Show option to remove all:
        if($command1!='remove_all'){
            echo '<br />';
            echo '<a class="remove-all" href="javascript:void(0);" onclick="$(\'.remove-all\').toggleClass(\'hidden\')">Remove All</a>';
            echo '<div class="remove-all hidden maxout"><b style="color: #FF0000;">WARNING</b>: All intents and all their links will be removed. ONLY do this after reviewing all orphans one-by-one and making sure they cannot become a child of an existing intent.<br /><br /></div>';
            echo '<a class="remove-all hidden maxout" href="/miner_app/admin_tools/orphan_intents/remove_all" onclick="">Confirm: <b>Remove All</b> &raquo;</a>';
        }

    } else {
        echo '<div class="alert alert-success maxout"><i class="fas fa-check-circle"></i> No orphans found!</div>';
    }

} elseif($action=='orphan_entities') {

    echo '<ul class="breadcrumb"><li><a href="/miner_app/admin_tools">Admin Tools</a></li><li><b>'.$moderation_tools['/miner_app/admin_tools/'.$action].'</b></li></ul>';

    $orphan_ens = $this->Entities_model->en_fetch(array(
        ' NOT EXISTS (SELECT 1 FROM table_links WHERE en_id=ln_child_entity_id AND ln_type_entity_id IN (' . join(',', $this->config->item('en_ids_4592')) . ') AND ln_status_entity_id IN ('.join(',', $this->config->item('en_ids_7360')) /* Link Statuses Active */.')) ' => null,
        'en_status_entity_id IN (' . join(',', $this->config->item('en_ids_7358')) . ')' => null, //Entity Statuses Active
        'en_id !=' => $this->config->item('en_focus_id'),
    ), array('skip_en__parents'));

    if(count($orphan_ens) > 0){

        //List orphans:
        foreach ($orphan_ens  as $count => $orphan_en) {

            //Show entity:
            echo '<div>'.($count+1).') <span data-toggle="tooltip" data-placement="right" title="'.$en_all_6177[$orphan_en['en_status_entity_id']]['m_name'].': '.$en_all_6177[$orphan_en['en_status_entity_id']]['m_desc'].'">' . $en_all_6177[$orphan_en['en_status_entity_id']]['m_icon'] . '</span> <a href="/entities/'.$orphan_en['en_id'].'"><b>'.$orphan_en['en_name'].'</b></a>';

            //Do we need to remove?
            if($command1=='remove_all'){

                //Remove links:
                $links_removed = $this->Entities_model->en_unlink($orphan_en['en_id'], $session_en['en_id']);

                //Remove entity:
                $this->Entities_model->en_update($orphan_en['en_id'], array(
                    'en_status_entity_id' => 6178, /* Entity Removed */
                ), true, $session_en['en_id']);

                //Show confirmation:
                echo ' [Entity + '.$links_removed.' links Removed]';

            }

            echo '</div>';

        }

        //Show option to remove all:
        if($command1!='remove_all'){
            echo '<br />';
            echo '<a class="remove-all" href="javascript:void(0);" onclick="$(\'.remove-all\').toggleClass(\'hidden\')">Remove All</a>';
            echo '<div class="remove-all hidden maxout"><b style="color: #FF0000;">WARNING</b>: All entities and all their links will be removed. ONLY do this after reviewing all orphans one-by-one and making sure they cannot become a child of an existing entity.<br /><br /></div>';
            echo '<a class="remove-all hidden maxout" href="/miner_app/admin_tools/orphan_entities/remove_all" onclick="">Confirm: <b>Remove All</b> &raquo;</a>';
        }

    } else {
        echo '<div class="alert alert-success maxout"><i class="fas fa-check-circle"></i> No orphans found!</div>';
    }
    

} elseif($action=='en_icon_search') {

    echo '<ul class="breadcrumb"><li><a href="/miner_app/admin_tools">Admin Tools</a></li><li><b>'.$moderation_tools['/miner_app/admin_tools/'.$action].'</b></li></ul>';

    //UI to compose a test message:
    echo '<form method="GET" action="">';

    echo '<div class="mini-header">Search For:</div>';
    echo '<input type="text" class="form-control border maxout" name="search_for" value="'.@$_GET['search_for'].'"><br />';


    if(isset($_GET['search_for']) && strlen($_GET['search_for'])>0){

        $matching_results = $this->Entities_model->en_fetch(array(
            'en_status_entity_id IN (' . join(',', $this->config->item('en_ids_7358')) . ')' => null, //Entity Statuses Active
            'LOWER(en_icon) LIKE \'%'.strtolower($_GET['search_for']).'%\'' => null,
        ));

        //List the matching search:
        echo '<table class="table table-condensed table-striped stats-table mini-stats-table">';


        echo '<tr class="panel-title down-border">';
        echo '<td style="text-align: left;" colspan="2">'.count($matching_results).' Results found</td>';
        echo '</tr>';


        if(count($matching_results) > 0){

            echo '<tr class="panel-title down-border" style="font-weight:bold !important;">';
            echo '<td style="text-align: left;">#</td>';
            echo '<td style="text-align: left;">Matching Search</td>';
            echo '</tr>';

            foreach($matching_results as $count=>$en){

                echo '<tr class="panel-title down-border">';
                echo '<td style="text-align: left;">'.($count+1).'</td>';
                echo '<td style="text-align: left;">'.echo_en_cache('en_all_6177' /* Entity Statuses */, $en['en_status_entity_id'], true, 'right').' <span class="icon-block">'.echo_en_icon($en).'</span><a href="/entities/'.$en['en_id'].'">'.$en['en_name'].'</a></td>';
                echo '</tr>';

            }
        }

        echo '</table>';
    }


    echo '<input type="submit" class="btn btn-primary" value="Search">';
    echo '</form>';

} elseif($action=='actionplan_debugger') {

    echo '<ul class="breadcrumb"><li><a href="/miner_app/admin_tools">Admin Tools</a></li><li><b>'.$moderation_tools['/miner_app/admin_tools/'.$action].'</b></li></ul>';

    //List this users Action Plan intents so they can choose:
    echo '<div>Choose one of your action plan intentions to debug:</div><br />';

    $user_intents = $this->Links_model->ln_fetch(array(
        'ln_creator_entity_id' => $session_en['en_id'],
        'ln_type_entity_id IN (' . join(',', $this->config->item('en_ids_7347')) . ')' => null, //Action Plan Intention Set
        'ln_status_entity_id IN (' . join(',', $this->config->item('en_ids_7364')) . ')' => null, //Link Statuses Incomplete
        'in_status_entity_id IN (' . join(',', $this->config->item('en_ids_7355')) . ')' => null, //Intent Statuses Public
    ), array('in_parent'), 0, 0, array('ln_order' => 'ASC'));

    foreach ($user_intents as $priority => $ln) {
        echo '<div>'.($priority+1).') <a href="/messenger/debug/' . $ln['in_id'] . '">' . echo_in_outcome($ln['in_outcome']) . '</a></div>';
    }

} elseif($action=='in_invalid_outcomes') {

    echo '<ul class="breadcrumb"><li><a href="/miner_app/admin_tools">Admin Tools</a></li><li><b>'.$moderation_tools['/miner_app/admin_tools/'.$action].'</b></li></ul>';

    $active_ins = $this->Intents_model->in_fetch(array(
        'in_status_entity_id IN (' . join(',', $this->config->item('en_ids_7356')) . ')' => null, //Intent Statuses Active
    ));

    //Give an overview:
    echo '<p>When the validation criteria change within the in_analyze_outcome() function, this page lists all the intents that no longer have a valid outcome.</p>';


    //List the matching search:
    echo '<table class="table table-condensed table-striped stats-table mini-stats-table">';


    echo '<tr class="panel-title down-border" style="font-weight:bold !important;">';
    echo '<td style="text-align: left;">#</td>';
    echo '<td style="text-align: left;">Invalid Outcome</td>';
    echo '</tr>';

    $invalid_outcomes = 0;
    foreach($active_ins as $count=>$in){

        $in_outcome_validation = $this->Intents_model->in_analyze_outcome($in['in_outcome'], $in['in_type_entity_id']);

        if(!$in_outcome_validation['status']){

            $invalid_outcomes++;

            //Update intent:
            echo '<tr class="panel-title down-border">';
            echo '<td style="text-align: left;">'.$invalid_outcomes.'</td>';
            echo '<td style="text-align: left;">'.echo_en_cache('en_all_4737' /* Intent Statuses */, $in['in_status_entity_id'], true, 'right').' <a href="/intents/'.$in['in_id'].'">'.echo_in_outcome($in['in_outcome']).'</a></td>';
            echo '</tr>';

        }

    }
    echo '</table>';

} elseif($action=='sync_intents') {

    echo '<table class="table table-condensed table-striped stats-table mini-stats-table">';

    foreach($this->Intents_model->in_fetch(array(
        'in_id' => 8000,
    )) as $in){

        $in_outcome_validation = $this->Intents_model->in_analyze_outcome($in['in_outcome'], $in['in_type_entity_id']);

        echo '<tr class="panel-title down-border">';
        echo '<td style="text-align: left;">'.$in['in_outcome'].'<div style="font-size: 0.7em;">VERB @'.$in['in_verb_entity_id'].' CONNECTION @'.$in['in_type_entity_id'].'</div></td>';
        echo '<td style="text-align: left;">'.$in['in_outcome'].'<div style="font-size: 0.7em;">VERB @'.$in['in_verb_entity_id'].' CONNECTION @'.$in['in_type_entity_id'].'</div></td>';
        echo '<td style="text-align: left;"></td>';
        echo '<td style="text-align: left;"></td>';
        echo '</tr>';


    }

    echo '</table>';

} elseif($action=='in_replace_outcomes') {


    echo '<ul class="breadcrumb"><li><a href="/miner_app/admin_tools">Admin Tools</a></li><li><b>'.$moderation_tools['/miner_app/admin_tools/'.$action].'</b></li></ul>';

    //UI to compose a test message:
    echo '<form method="GET" action="">';

    echo '<div class="mini-header">Search For:</div>';
    echo '<input type="text" class="form-control border maxout" name="search_for" value="'.@$_GET['search_for'].'"><br />';


    $search_for_is_set = (isset($_GET['search_for']) && strlen($_GET['search_for'])>0);
    $replace_with_is_set = (isset($_GET['replace_with']) && strlen($_GET['replace_with'])>0);
    $qualifying_replacements = 0;
    $completed_replacements = 0;
    $replace_with_is_confirmed = false;

    if($search_for_is_set){

        $matching_results = $this->Intents_model->in_fetch(array(
            'in_status_entity_id IN (' . join(',', $this->config->item('en_ids_7356')) . ')' => null, //Intent Statuses Active
            'LOWER(in_outcome) LIKE \'%'.strtolower($_GET['search_for']).'%\'' => null,
        ));

        //List the matching search:
        echo '<table class="table table-condensed table-striped stats-table mini-stats-table">';


        echo '<tr class="panel-title down-border">';
        echo '<td style="text-align: left;" colspan="4">'.count($matching_results).' Results found</td>';
        echo '</tr>';


        if(count($matching_results) < 1){

            $replace_with_is_set = false;
            unset($_GET['confirm_statement']);
            unset($_GET['replace_with']);

        } else {

            $confirmation_keyword = 'Replace '.count($matching_results);
            $replace_with_is_confirmed = (isset($_GET['confirm_statement']) && strtolower($_GET['confirm_statement'])==strtolower($confirmation_keyword));

            echo '<tr class="panel-title down-border" style="font-weight:bold !important;">';
            echo '<td style="text-align: left;">#</td>';
            echo '<td style="text-align: left;">Matching Search</td>';
            echo '<td style="text-align: left;">'.( $replace_with_is_set ? 'Replacement' : '' ).'</td>';
            echo '<td style="text-align: left;">&nbsp;</td>';
            echo '</tr>';

            foreach($matching_results as $count=>$in){

                if($replace_with_is_set){
                    //Do replacement:
                    $new_outcome = str_replace($_GET['search_for'],$_GET['replace_with'],$in['in_outcome']);
                    $in_outcome_validation = $this->Intents_model->in_analyze_outcome($new_outcome, $in['in_type_entity_id']);

                    if($in_outcome_validation['status']){
                        $qualifying_replacements++;
                    }
                }

                if($replace_with_is_confirmed && $in_outcome_validation['status']){
                    //Update intent:
                    $this->Intents_model->in_update($in['in_id'], array(
                        'in_outcome' => $in_outcome_validation['in_cleaned_outcome'],
                        'in_verb_entity_id' => $in_outcome_validation['detected_in_verb_entity_id'],
                    ), true, $session_en['en_id']);
                    $completed_replacements++;
                }

                echo '<tr class="panel-title down-border">';
                echo '<td style="text-align: left;">'.($count+1).'</td>';
                echo '<td style="text-align: left;">'.echo_en_cache('en_all_4737' /* Intent Statuses */, $in['in_status_entity_id'], true, 'right').' <a href="/intents/'.$in['in_id'].'">'.$in['in_outcome'].'</a></td>';

                if($replace_with_is_set){

                    echo '<td style="text-align: left;">'.$new_outcome.'</td>';
                    echo '<td style="text-align: left;">'.( !$in_outcome_validation['status'] ? ' <i class="fas fa-exclamation-triangle"></i> Error: '.$in_outcome_validation['message'] : ( $replace_with_is_confirmed && $in_outcome_validation['status'] ? '<i class="fas fa-check-circle"></i> Outcome Updated' : '') ).'</td>';
                } else {
                    //Show parents now:
                    echo '<td style="text-align: left;">';


                    //Loop through parents:
                    $en_all_7585 = $this->config->item('en_all_7585'); // Intent Types
                    foreach ($this->Links_model->ln_fetch(array(
                        'ln_status_entity_id IN (' . join(',', $this->config->item('en_ids_7360')) . ')' => null, //Link Statuses Active
                        'in_status_entity_id IN (' . join(',', $this->config->item('en_ids_7356')) . ')' => null, //Intent Statuses Active
                        'ln_type_entity_id IN (' . join(',', $this->config->item('en_ids_4486')) . ')' => null, //Intent Link Connectors
                        'ln_child_intent_id' => $in['in_id'],
                    ), array('in_parent')) as $in_parent) {
                        echo '<span class="in_child_icon_' . $in_parent['in_id'] . '"><a href="/intents/' . $in_parent['in_id'] . '" data-toggle="tooltip" title="' . $in_parent['in_outcome'] . '" data-placement="bottom">' . $en_all_7585[$in_parent['in_completion_method_entity_id']]['m_icon'] . '</a> &nbsp;</span>';
                    }

                    echo '</td>';
                    echo '<td style="text-align: left;"></td>';
                }


                echo '</tr>';

            }
        }

        echo '</table>';
    }


    if($search_for_is_set && count($matching_results) > 0 && !$completed_replacements){
        //now give option to replace with:
        echo '<div class="mini-header">Replace With:</div>';
        echo '<input type="text" class="form-control border maxout" name="replace_with" value="'.@$_GET['replace_with'].'"><br />';
    }

    if($replace_with_is_set && !$completed_replacements){
        if($qualifying_replacements==count($matching_results) /*No Errors*/){
            //now give option to replace with:
            echo '<div class="mini-header">Confirm Replacement by Typing "'.$confirmation_keyword.'":</div>';
            echo '<input type="text" class="form-control border maxout" name="confirm_statement" value="'. @$_GET['confirm_statement'] .'"><br />';
        } else {
            echo '<div class="alert alert-danger"><i class="fas fa-exclamation-triangle"></i> Fix errors above to then apply search/replace</div>';
        }
    }


    echo '<input type="submit" class="btn btn-primary" value="Go">';
    echo '</form>';


} elseif($action=='sync_in_verbs') {

    echo '<ul class="breadcrumb"><li><a href="/miner_app/admin_tools">Admin Tools</a></li><li><b>'.$moderation_tools['/miner_app/admin_tools/'.$action].'</b></li></ul>';

    //Would ensure intents have synced statuses:
    $count = 0;
    $fixed = 0;
    foreach($this->Intents_model->in_fetch() as $in){

        $count++;

        //Validate Intent Outcome:
        $in_verb_entity_id = in_outcome_verb_id($in['in_outcome']);

        if($in_verb_entity_id > 0 && $in_verb_entity_id != $in['in_verb_entity_id']) {

            //Not a match, fix it:
            $fixed++;
            $this->Intents_model->in_update($in['in_id'], array(
                'in_verb_entity_id' => $in_verb_entity_id,
            ), true, $session_en['en_id']);

        }
    }

    echo '<div>'.$fixed.'/'.$count.' Intent verbs fixed</div>';

} elseif($action=='identical_intent_outcomes') {

    echo '<ul class="breadcrumb"><li><a href="/miner_app/admin_tools">Admin Tools</a></li><li><b>'.$moderation_tools['/miner_app/admin_tools/'.$action].'</b></li></ul>';

    //Do a query to detect intents with the exact same title:
    $q = $this->db->query('select in1.* from table_intents in1 where (select count(*) from table_intents in2 where in2.in_outcome = in1.in_outcome AND in2.in_status_entity_id IN (' . join(',', $this->config->item('en_ids_7356')) . ')) > 1 AND in1.in_status_entity_id IN (' . join(',', $this->config->item('en_ids_7356')) . ') ORDER BY in1.in_outcome ASC');
    $duplicates = $q->result_array();

    if(count($duplicates) > 0){

        $prev_title = null;
        foreach ($duplicates as $in) {
            if ($prev_title != $in['in_outcome']) {
                echo '<hr />';
                $prev_title = $in['in_outcome'];
            }

            echo '<div><span data-toggle="tooltip" data-placement="right" title="'.$en_all_4737[$in['in_status_entity_id']]['m_name'].': '.$en_all_4737[$in['in_status_entity_id']]['m_desc'].'">' . $en_all_4737[$in['in_status_entity_id']]['m_icon'] . '</span> <a href="/intents/' . $in['in_id'] . '"><b>' . $in['in_outcome'] . '</b></a> #' . $in['in_id'] . '</div>';
        }

    } else {
        echo '<div class="alert alert-success maxout"><i class="fas fa-check-circle"></i> No duplicates found!</div>';
    }

} elseif($action=='identical_entity_names') {

    echo '<ul class="breadcrumb"><li><a href="/miner_app/admin_tools">Admin Tools</a></li><li><b>'.$moderation_tools['/miner_app/admin_tools/'.$action].'</b></li></ul>';

    $q = $this->db->query('select en1.* from table_entities en1 where (select count(*) from table_entities en2 where en2.en_name = en1.en_name AND en2.en_status_entity_id IN (' . join(',', $this->config->item('en_ids_7358')) . ')) > 1 AND en1.en_status_entity_id IN (' . join(',', $this->config->item('en_ids_7358')) . ') ORDER BY en1.en_name ASC');
    $duplicates = $q->result_array();

    if(count($duplicates) > 0){

        $prev_title = null;
        foreach ($duplicates as $en) {

            if ($prev_title != $en['en_name']) {
                echo '<hr />';
                $prev_title = $en['en_name'];
            }

            echo '<span data-toggle="tooltip" data-placement="right" title="'.$en_all_6177[$en['en_status_entity_id']]['m_name'].': '.$en_all_6177[$en['en_status_entity_id']]['m_desc'].'">' . $en_all_6177[$en['en_status_entity_id']]['m_icon'] . '</span> <a href="/entities/' . $en['en_id'] . '"><b>' . $en['en_name'] . '</b></a> @' . $en['en_id'] . '<br />';
        }

    } else {
        echo '<div class="alert alert-success maxout"><i class="fas fa-check-circle"></i> No duplicates found!</div>';
    }


} elseif($action=='reset_all_credits') {


    die('Locked via code base');

    boost_power();

    //Hidden function to reset points:
    $all_link_types = $this->Links_model->ln_fetch(array(
        'ln_status_entity_id IN (' . join(',', $this->config->item('en_ids_7360')) . ')' => null, //Link Statuses Active
    ), array('en_type'), 0, 0, array('en_name' => 'ASC'), 'COUNT(ln_type_entity_id) as trs_count, en_name, en_icon, ln_type_entity_id', 'ln_type_entity_id, en_name, en_icon');


    $total_updated = 0;
    foreach ($all_link_types as $count => $ln) {

        $credits = fetch_credits($ln['ln_type_entity_id']);

        //Update all links with out-of-date points:
        $this->db->query("UPDATE table_links SET ln_credits = ".$credits." WHERE ln_credits != ".$credits." AND ln_type_entity_id = " . $ln['ln_type_entity_id']);

        //Count how many updates:
        $total_updated += $this->db->affected_rows();

    }

    echo $total_updated.' links updated with new credit rates';


} elseif($action=='or__children') {

    echo '<br /><p>Active <a href="/entities/6914">Intent Answer Types</a> are listed below.</p><br />';

    $all_steps = 0;
    $all_children = 0;
    $updated = 0;
    $new_ln_type_entity_id = 7485; //User Step Answer Unlock

    foreach ($this->Intents_model->in_fetch(array(
        'in_status_entity_id IN (' . join(',', $this->config->item('en_ids_7356')) . ')' => null, //Intent Statuses Active
        'in_completion_method_entity_id IN (' . join(',', $this->config->item('en_ids_7712')) . ')' => null,
    ), array(), 0, 0, array('in_id' => 'DESC')) as $count => $in) {

        echo '<div>'.($count+1).') '.echo_en_cache('en_all_4737' /* Intent Statuses */, $in['in_status_entity_id']).' '.echo_en_cache('en_all_6193' /* OR Intents */, $in['in_completion_method_entity_id']).' <b><a href="https://mench.com/intents/'.$in['in_id'].'">'.echo_in_outcome($in['in_outcome']).'</a></b></div>';

        echo '<ul>';
        //Fetch all children for this OR:
        foreach($this->Links_model->ln_fetch(array(
            'ln_status_entity_id IN (' . join(',', $this->config->item('en_ids_7360')) . ')' => null, //Link Statuses Active
            'in_status_entity_id IN (' . join(',', $this->config->item('en_ids_7356')) . ')' => null, //Intent Statuses Active
            'ln_type_entity_id' => 4228, //Intent Link Regular Step
            'ln_parent_intent_id' => $in['in_id'],
        ), array('in_child'), 0, 0, array('ln_order' => 'ASC')) as $child_or){

            $qualified_update = ( $child_or['in_completion_method_entity_id']==6677 /* Intent Read-Only */ && in_array($child_or['in_type_entity_id'], $this->config->item('en_ids_7582')) /* Intent Action Plan Addable */ );

            //Count completions:
            if($qualified_update){

                $user_steps = $this->Links_model->ln_fetch(array(
                    'ln_type_entity_id IN (' . join(',', $this->config->item('en_ids_6255')) . ')' => null, //Action Plan Steps Progressed
                    'ln_parent_intent_id' => $child_or['in_id'],
                    'ln_status_entity_id IN (' . join(',', $this->config->item('en_ids_7359')) . ')' => null, //Link Statuses Public
                ), array(), 0);
                $all_steps += count($user_steps);

            } else {
                $user_steps = array();
            }

            $all_children++;
            echo '<li>'.echo_en_cache('en_all_6186' /* Link Statuses */, $child_or['ln_status_entity_id']).' '.echo_en_cache('en_all_4737' /* Intent Statuses */, $child_or['in_status_entity_id']).' '.echo_en_cache('en_all_7585', $child_or['in_completion_method_entity_id']).' <a href="https://mench.com/intents/'.$child_or['in_id'].'" '.( $qualified_update ? '' : 'style="color:#FF0000;"' ).'>'.echo_in_outcome($child_or['in_outcome']).'</a>'.( count($user_steps) > 0 ? ' / Steps: '.count($user_steps) : '' ).'</li>';
        }
        echo '</ul>';
        echo '<hr />';
    }

    echo 'All Steps Taken: '.$all_steps.( $updated > 0 ? ' ('.$updated.' updated)' : '' ).' across '.$all_children.' answers';

} elseif($action=='assessment_marks_list_all') {


    echo '<ul class="breadcrumb"><li><a href="/miner_app/admin_tools">Admin Tools</a></li><li><b>'.$moderation_tools['/miner_app/admin_tools/'.$action].'</b></li></ul>';

    echo '<p>Below are all the Conditional Step Links:</p>';
    echo '<table class="table table-condensed table-striped maxout" style="text-align: left;">';

    $en_all_6103 = $this->config->item('en_all_6103'); //Link Metadata
    $en_all_6186 = $this->config->item('en_all_6186'); //Link Statuses

    echo '<tr style="font-weight: bold;">';
    echo '<td colspan="4" style="text-align: left;">'.$en_all_6103[6402]['m_icon'].' '.$en_all_6103[6402]['m_name'].'</td>';
    echo '</tr>';
    $counter = 0;
    $total_count = 0;
    foreach ($this->Links_model->ln_fetch(array(
        'ln_status_entity_id IN (' . join(',', $this->config->item('en_ids_7360')) . ')' => null, //Link Statuses Active
        'in_status_entity_id IN (' . join(',', $this->config->item('en_ids_7356')) . ')' => null, //Intent Statuses Active
        'ln_type_entity_id' => 4229, //Intent Link Locked Step
        'LENGTH(ln_metadata) > 0' => null,
    ), array('in_child'), 0, 0) as $in_ln) {
        //Echo HTML format of this message:
        $metadata = unserialize($in_ln['ln_metadata']);
        $mark = echo_in_marks($in_ln);
        if($mark){

            //Fetch parent intent:
            $parent_ins = $this->Intents_model->in_fetch(array(
                'in_id' => $in_ln['ln_parent_intent_id'],
            ));

            $counter++;
            echo '<tr>';
            echo '<td style="width: 50px;">'.$counter.'</td>';
            echo '<td style="font-weight: bold; font-size: 1.3em; width: 100px;">'.echo_in_marks($in_ln).'</td>';
            echo '<td>'.$en_all_6186[$in_ln['ln_status_entity_id']]['m_icon'].'</td>';
            echo '<td style="text-align: left;">';

            echo '<div>';
            echo '<span style="width:25px; display:inline-block; text-align:center;">'.$en_all_4737[$parent_ins[0]['in_status_entity_id']]['m_icon'].'</span>';
            echo '<a href="/intents/'.$parent_ins[0]['in_id'].'">'.$parent_ins[0]['in_outcome'].'</a>';
            echo '</div>';

            echo '<div>';
            echo '<span style="width:25px; display:inline-block; text-align:center;">'.$en_all_4737[$in_ln['in_status_entity_id']]['m_icon'].'</span>';
            echo '<a href="/intents/'.$in_ln['in_id'].'">'.$in_ln['in_outcome'].' [child]</a>';
            echo '</div>';

            if(count($this->Links_model->ln_fetch(array(
                    'ln_status_entity_id IN (' . join(',', $this->config->item('en_ids_7360')) . ')' => null, //Link Statuses Active
                    'in_status_entity_id IN (' . join(',', $this->config->item('en_ids_7356')) . ')' => null, //Intent Statuses Active
                    'in_completion_method_entity_id NOT IN (6907,6914)' => null, //NOT AND/OR Lock
                    'ln_type_entity_id IN (' . join(',', $this->config->item('en_ids_4486')) . ')' => null, //Intent Link Connectors
                    'ln_child_intent_id' => $in_ln['in_id'],
                ), array('in_parent'))) > 1 || $in_ln['in_completion_method_entity_id'] != 6677){

                echo '<div>';
                echo 'NOT COOL';
                echo '</div>';

            } else {

                //Update user progression link type:
                $user_steps = $this->Links_model->ln_fetch(array(
                    'ln_type_entity_id IN (' . join(',', $this->config->item('en_ids_6255')) . ')' => null, //Action Plan Steps Progressed
                    'ln_parent_intent_id' => $in_ln['in_id'],
                    'ln_status_entity_id IN (' . join(',', $this->config->item('en_ids_7359')) . ')' => null, //Link Statuses Public
                ), array(), 0);

                $updated = 0;

                echo '<div>Total Steps: '.count($user_steps).'</div>';
                $total_count += count($user_steps);

            }

            echo '</td>';
            echo '</tr>';

        }
    }

    echo '</table>';

    echo 'TOTALS: '.$total_count;

    if(1){
        echo '<p>Below are all the fixed step links that award/subtract Completion Marks:</p>';
        echo '<table class="table table-condensed table-striped maxout" style="text-align: left;">';

        echo '<tr style="font-weight: bold;">';
        echo '<td colspan="4" style="text-align: left;">Completion Marks</td>';
        echo '</tr>';

        $counter = 0;
        foreach ($this->Links_model->ln_fetch(array(
            'ln_status_entity_id IN (' . join(',', $this->config->item('en_ids_7360')) . ')' => null, //Link Statuses Active
            'in_status_entity_id IN (' . join(',', $this->config->item('en_ids_7356')) . ')' => null, //Intent Statuses Active
            'ln_type_entity_id' => 4228, //Intent Link Regular Step
            'LENGTH(ln_metadata) > 0' => null,
        ), array('in_child'), 0, 0) as $in_ln) {
            //Echo HTML format of this message:
            $metadata = unserialize($in_ln['ln_metadata']);
            $tr__assessment_points = ( isset($metadata['tr__assessment_points']) ? $metadata['tr__assessment_points'] : 0 );
            if($tr__assessment_points!=0){

                //Fetch parent intent:
                $parent_ins = $this->Intents_model->in_fetch(array(
                    'in_id' => $in_ln['ln_parent_intent_id'],
                ));


                //Update Completion Marks if outside of range (Handy if in_completion_marks values are reduced)
                /*
                if($tr__assessment_points > 1){
                    //Set to 1:
                    update_metadata('ln', $in_ln['ln_id'], array(
                        'tr__assessment_points' => 1,
                    ));
                } elseif($tr__assessment_points < 0){
                    update_metadata('ln', $in_ln['ln_id'], array(
                        'tr__assessment_points' => 0,
                    ));
                }
                */


                $counter++;
                echo '<tr>';
                echo '<td style="width: 50px;">'.$counter.'</td>';
                echo '<td style="font-weight: bold; font-size: 1.3em; width: 100px;">'.echo_in_marks($in_ln).'</td>';
                echo '<td>'.$en_all_6186[$in_ln['ln_status_entity_id']]['m_icon'].'</td>';
                echo '<td style="text-align: left;">';
                echo '<div>';
                echo '<span style="width:25px; display:inline-block; text-align:center;">'.$en_all_4737[$parent_ins[0]['in_status_entity_id']]['m_icon'].'</span>';
                echo '<a href="/intents/'.$parent_ins[0]['in_id'].'">'.$parent_ins[0]['in_outcome'].'</a>';
                echo '</div>';

                echo '<div>';
                echo '<span style="width:25px; display:inline-block; text-align:center;">'.$en_all_4737[$in_ln['in_status_entity_id']]['m_icon'].'</span>';
                echo '<a href="/intents/'.$in_ln['in_id'].'">'.$in_ln['in_outcome'].'</a>';
                echo '</div>';
                echo '</td>';
                echo '</tr>';

            }
        }

        echo '</table>';
    }

} elseif($action=='assessment_marks_birds_eye') {

    //Give an overview of the point links in a hierchial format to enable moderators to overview:
    $_GET['starting_in']    = ( isset($_GET['starting_in']) && intval($_GET['starting_in']) > 0 ? $_GET['starting_in'] : $this->config->item('in_focus_id') );
    $_GET['depth_levels']   = ( isset($_GET['depth_levels']) && intval($_GET['depth_levels']) > 0 ? $_GET['depth_levels'] : 3 );

    echo '<ul class="breadcrumb"><li><a href="/miner_app/admin_tools">Admin Tools</a></li><li><b>'.$moderation_tools['/miner_app/admin_tools/'.$action].'</b></li></ul>';


    echo '<form method="GET" action="">';

    echo '<div class="score_range_box">
            <div class="form-group label-floating is-empty"
                 style="max-width:550px; margin:1px 0 10px; display: inline-block;">
                <div class="input-group border">
                    <span class="input-group-addon addon-lean addon-grey" style="color:#2f2739; font-weight: 300;">Start at #</span>
                    <input style="padding-left:3px; min-width:56px;" type="number" min="1" step="1" name="starting_in" id="starting_in" value="'.$_GET['starting_in'].'" class="form-control">
                    <span class="input-group-addon addon-lean addon-grey" style="color:#2f2739; font-weight: 300; border-left: 1px solid #ccc;"> and go </span>
                    <input style="padding-left:3px; min-width:56px;" type="number" min="1" step="1" name="depth_levels" id="depth_levels" value="'.$_GET['depth_levels'].'" class="form-control">
                    <span class="input-group-addon addon-lean addon-grey" style="color:#2f2739; font-weight: 300; border-left: 1px solid #ccc; border-right:0px solid #FFF;"> levels deep.</span>
                </div>
            </div>
            <input type="submit" class="btn btn-primary btn-sm" value="Go" style="display: inline-block; margin-top: -41px;" />
        </div>';

    echo '</form>';

    //Load the report via Ajax here on page load:
    echo '<div id="in_report_conditional_steps"></div>';
    echo '<script>

$(document).ready(function () {
//Show spinner:
$(\'#in_report_conditional_steps\').html(\'<span><i class="fas fa-yin-yang fa-spin"></i> \' + echo_ying_yang() +  \'</span>\').hide().fadeIn();
//Load report based on input fields:
$.post("/intents/in_report_conditional_steps", {
    starting_in: parseInt($(\'#starting_in\').val()),
    depth_levels: parseInt($(\'#depth_levels\').val()),
}, function (data) {
    if (!data.status) {
        //Show Error:
        $(\'#in_report_conditional_steps\').html(\'<span style="color:#FF0000;">Error: \'+ data.message +\'</span>\');
    } else {
        //Load Report:
        $(\'#in_report_conditional_steps\').html(data.message);
        $(\'[data-toggle="tooltip"]\').tooltip();
    }
});
});

</script>';


} elseif($action=='compose_test_message') {


    if(isset($_POST['test_message'])){

        echo '<ul class="breadcrumb"><li><a href="/miner_app/admin_tools">Admin Tools</a></li><li><a href="/miner_app/admin_tools/'.$action.'">'.$moderation_tools['/miner_app/admin_tools/'.$action].'</a></li><li><b>Review Message</b></li></ul>';

        if(intval($_POST['push_message']) && intval($_POST['recipient_en'])){

            //Send to Facebook Messenger:
            $msg_validation = $this->Communication_model->dispatch_message(
                $_POST['test_message'],
                array('en_id' => intval($_POST['recipient_en'])),
                true
            );

        } elseif(intval($_POST['recipient_en']) > 0) {

            $msg_validation = $this->Communication_model->dispatch_validate_message($_POST['test_message'], array('en_id' => $_POST['recipient_en']), $_POST['push_message']);

        } else {

            echo 'Missing recipient';

        }

        //Show results:
        print_r($msg_validation);

    } else {

        echo '<ul class="breadcrumb"><li><a href="/miner_app/admin_tools">Admin Tools</a></li><li><b>'.$moderation_tools['/miner_app/admin_tools/'.$action].'</b></li></ul>';

        //UI to compose a test message:
        echo '<form method="POST" action="" class="maxout">';

        echo '<div class="mini-header">Message:</div>';
        echo '<textarea name="test_message" class="form-control border" style="width:400px; height: 200px;"></textarea><br />';

        echo '<div class="mini-header">Recipient Entity ID:</div>';
        echo '<input type="number" class="form-control border" name="recipient_en" value="1"><br />';

        echo '<div class="mini-header">Format Is Messenger:</div>';
        echo '<input type="number" class="form-control border" name="push_message" value="1"><br /><br />';


        echo '<input type="submit" class="btn btn-primary" value="Compose Test Message">';
        echo '</form>';

    }

} else {

    //Oooooopsi, unknown:
    echo '<h1>Unknown Function</h1>';
    echo 'Not sure how you landed here!';

}


echo '<br /><br /><br /><br />';

?>