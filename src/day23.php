<?php

namespace Robchett\Aoc2024;

/**
 * --- Day 23: LAN Party ---
 * As The Historians wander around a secure area at Easter Bunny HQ, you come across posters for a LAN party scheduled for today! Maybe you can find it; you connect to a nearby datalink port and download a map of the local network (your puzzle input).
 * 
 * The network map provides a list of every connection between two computers. For example:
 * 
 * kh-tc
 * qp-kh
 * de-cg
 * ka-co
 * yn-aq
 * qp-ub
 * cg-tb
 * vc-aq
 * tb-ka
 * wh-tc
 * yn-cg
 * kh-ub
 * ta-co
 * de-co
 * tc-td
 * tb-wq
 * wh-td
 * ta-ka
 * td-qp
 * aq-cg
 * wq-ub
 * ub-vc
 * de-ta
 * wq-aq
 * wq-vc
 * wh-yn
 * ka-de
 * kh-ta
 * co-tc
 * wh-qp
 * tb-vc
 * td-yn
 * Each line of text in the network map represents a single connection; the line kh-tc represents a connection between the computer named kh and the computer named tc. Connections aren't directional; tc-kh would mean exactly the same thing.
 * 
 * LAN parties typically involve multiplayer games, so maybe you can locate it by finding groups of connected computers. Start by looking for sets of three computers where each computer in the set is connected to the other two computers.
 * 
 * In this example, there are 12 such sets of three inter-connected computers:
 * 
 * aq,cg,yn
 * aq,vc,wq
 * co,de,ka
 * co,de,ta
 * co,ka,ta
 * de,ka,ta
 * kh,qp,ub
 * qp,td,wh
 * tb,vc,wq
 * tc,td,wh
 * td,wh,yn
 * ub,vc,wq
 * If the Chief Historian is here, and he's at the LAN party, it would be best to know that right away. You're pretty sure his computer's name starts with t, so consider only sets of three computers where at least one computer's name starts with t. That narrows the list down to 7 sets of three inter-connected computers:
 * 
 * co,de,ta
 * co,ka,ta
 * de,ka,ta
 * qp,td,wh
 * tb,vc,wq
 * tc,td,wh
 * td,wh,yn
 * Find all the sets of three inter-connected computers. How many contain at least one computer with a name that starts with t?
 * 
 * --- Part Two ---
 * There are still way too many results to go through them all. You'll have to find the LAN party another way and go there yourself.
 * 
 * Since it doesn't seem like any employees are around, you figure they must all be at the LAN party. If that's true, the LAN party will be the largest set of computers that are all connected to each other. That is, for each computer at the LAN party, that computer will have a connection to every other computer at the LAN party.
 * 
 * In the above example, the largest set of computers that are all connected to each other is made up of co, de, ka, and ta. Each computer in this set has a connection to every other computer in the set:
 * 
 * ka-co
 * ta-co
 * de-co
 * ta-ka
 * de-ta
 * ka-de
 * The LAN party posters say that the password to get into the LAN party is the name of every computer at the LAN party, sorted alphabetically, then joined together with commas. (The people running the LAN party are clearly a bunch of nerds.) In this example, the password would be co,de,ka,ta.
 * 
 * What is the password to get into the LAN party?
 * @template-implements Task<int, list<string>>
 */
return new class($input) implements Task {

    public array $links = [];

    #[\Override] function __construct(string $input)
    {
        $this->links = array_map(fn($s) => explode("-", trim($s)), explode("\n", trim($input)));
    }

    #[\Override] public function task1(): TaskOutput
    {
        $sets = [];
        $checks = 0;
        for ($i = 0; $i < count($this->links); $i++) {
            [$i1,$i2] = $i0 = $this->links[$i];
            $hasTi = str_starts_with($i1, 't') || str_starts_with($i2, 't');
            for ($j = $i + 1; $j < count($this->links); $j++) {
                [$j1,$j2] = $j0 = $this->links[$j];      
                $hasTj = str_starts_with($j1, 't') || str_starts_with($j2, 't');
                if ( ! ($hasTi || $hasTj) || (!in_array($j1, $i0) && !in_array($j2, $i0))) {
                    continue;
                }
                for ($k = $j + 1; $k < count($this->links); $k++) {
                    [$k1,$k2] = $this->links[$k];
                    $checks++;
                    if (count($set = array_unique([$i1,$i2,$j1,$j2,$k1,$k2])) != 3) {
                        continue;
                    }
                    sort($set);
                    $sets[implode(",", $set)] = true;
                }
            }
        }
        print_r(":$checks\n");
        $sets = array_filter(array_keys($sets), fn($s) => str_contains($s, 't'));
        print_r($sets);
        return new TaskOutput(count($sets));
    }

    #[\Override] public function task2(): TaskOutput
    {
        $connections = [];
        foreach ($this->links as [$a,$b]) {
            $connections[$a] ??= [$a];
            $connections[$b] ??= [$b];
            $connections[$a][] = $b;
            $connections[$b][] = $a;
        }
        
        $foundNetworks = [];
        $largestNetworks = $this->links;
        while (true) {
            $nextSet = [];
            foreach ($largestNetworks as $nodes) {
                $union = array_intersect(...array_map(fn($i) => $connections[$i], $nodes));
                if (count($union) > count($nodes)) {
                    $diff = array_diff($union, $nodes);
                    foreach ($diff as $d) {
                        $newSet = [...$nodes, $d];
                        sort($newSet);
                        $nextSet[implode(",",$newSet)] = $newSet;
                    }
                }     
            }

            if (! $nextSet) {
                break;
            }
            $largestNetworks = $nextSet;
        }
        return new TaskOutput(array_key_first($largestNetworks));
    }
};